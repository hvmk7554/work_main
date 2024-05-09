<?php

namespace App\Notifications;

use App\Helpers\Utils;
use App\Models\ChannelNotification;
use App\Models\Config;
use App\Models\Student;
use App\Models\TrackingNotiSubscription;
use App\Models\TrackingTemporary;
use App\Models\ZaloSendZNS;
use App\Models\ZaloTemplate;
use App\Services\External\MarathonIntegrationService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class SendTrackingNoty
{
    protected Collection $channels;

    protected Student|null $student;

    protected ZaloSendZNS|null $zaloSendZNS;

    protected ZaloTemplate $zaloTemplate;

    protected templateDataSendNotyObject $templateDataSendNotyObject;

    //hardcode
    public bool $isRenewal = false;
    public templateDataEmailRenewal|null $emailRenewal = null;

    protected int|string|null $fptSmsId = null;

    protected string|null $emailId = null;

    protected int|null $trackingTemporariesId = null;

    public static function TrackingNoty(
        Collection $channel,
        Student|null $student,
        ZaloSendZNS|null $zaloSendZNS,
        ZaloTemplate $zaloTemplate,
        string|int|null $zaloPhone,
        string|int|null $phone,
        string|null $email,
        string|int|null $templateId,
        string|int|null $objectId,
        string|null $objectType,
        array|null  $params,
        int|null $trackingTemporariesId = null): SendTrackingNoty
    {
        $studentId = $student?->getKey() ?? null;
        if(!$student && !is_null($phone) && $phone != ''){
            $studentId = Student::query()->where('phone_number',Utils::phoneInternationalToLocal($phone))->first()?->getKey() ?? null;
        }

        $sendTrackingNoty = new self();
        $sendTrackingNoty->channels = $channel;
        $sendTrackingNoty->student = $student;
        $sendTrackingNoty->zaloSendZNS = $zaloSendZNS;
        $sendTrackingNoty->zaloTemplate = $zaloTemplate;
        $sendTrackingNoty->trackingTemporariesId = $trackingTemporariesId;
        $sendTrackingNoty->templateDataSendNotyObject = new templateDataSendNotyObject(
            $studentId ?? null,
            $phone ?? null,
            $zaloPhone ?? null,
            $email ?? null,
            $templateId ?? null,
            $objectId ?? null,
            $objectType ?? null,
            $params ?? null);

        return $sendTrackingNoty;
    }

    public function handle(): void
    {
        foreach ($this->channels->groupBy('priority') as $channelNotifications){
            $success = false;

            foreach ($channelNotifications as $channelNotification){
                if($channelNotification->type == ChannelNotification::CHANNEL_EMAIL){
                    $responseSendZns = $this->handleTrackingByEmail($channelNotification->type,$this->zaloTemplate);
                }

                if(in_array($channelNotification->type,[ChannelNotification::CHANNEL_ZALO,ChannelNotification::CHANNEL_SMS])){
                    $responseSendZns = $this->handleTrackingByPhone($channelNotification->type,$this->zaloTemplate);
                }

                if(isset($responseSendZns['error']) && !$responseSendZns['error']) $success = true;
            }

            if(!Config::query()->first()->noti_send_all_channel && $success) break;
        }
    }

    /**
     * @param array{phone: string, params: array, object_id: string, object_type: string} $data
     * @param ZaloTemplate $zaloTemplate
     * @return mixed
     */
    public function sendZnsTrackingNoti(array $data,ZaloTemplate $zaloTemplate): mixed
    {
        $dataResponse = Utils::sendZaloZNS([
            'phone' => Utils::getStringZaloPhone($data['phone']),
            'template_id' => $zaloTemplate->template_id,
            'template_data' => $data['params']
        ]);
        if(isset($dataResponse['code']) && $dataResponse['code'] != 1) {
            $notiData['phone'] = $data['phone'];
            $notiData['template_id'] = $zaloTemplate->template_id;
            $notiData['template_name'] = $zaloTemplate->title;
            $notiData['object_id'] = $data['object_id'] ?? null;
            $notiData['object_type'] = $data['object_type'] ?? null;
            $notiData['error'] = $dataResponse["message"];
            Utils::sendGoogleNotiZnsError($notiData);
            return self::returnError(true,$dataResponse["message"]);
        }

        return self::returnError(false,$dataResponse["message"]);
    }

    /**
     * @param array{params : array, email: string} $templateData
     * @param ZaloTemplate $zaloTemplate
     * @return array
     */
    public function sendEmailTracking(array $templateData,ZaloTemplate $zaloTemplate): array
    {
        $content = $zaloTemplate->content_email ?? '';
        foreach ($templateData['params'] as $key => $value){
            $content = str_replace("<$key>",$value,$content);
        }

        if($this->isRenewal){
            $responseEmail = Utils::sendEmailRenewal([
                "from" => $this->emailRenewal->from,
                "to" => $this->emailRenewal->to,
                "subject" => $this->emailRenewal->subject,
                "course_name" => $this->emailRenewal->courseName,
                "line_item_name" => $this->emailRenewal->lineItemName,
                "deal_id" => $this->emailRenewal->dealId,
                "phone_number" => $this->emailRenewal->phoneNumber,
                "deal_amount" => $this->emailRenewal->dealAmount,
                "subs_remain" => $this->emailRenewal->subsRemain,
            ]);
            return self::returnError($responseEmail['error'],$responseEmail['message']);
        }else{
            $subject = match ($zaloTemplate->system_type){
                ZaloTemplate::SYSTEM_TYPE_LDB_REPORT => "Marathon Education - Báo cáo học tập mới nhất của khoá học ".$templateData['params']['course_name']." !",
                ZaloTemplate::SYSTEM_TYPE_NEED_SAVE_FEEDBACK => "Đang có ".$templateData['params']['num_course']." khoá học có buổi học cần điền nhận xét cho học sinh!",
                default => $zaloTemplate->title ?? null
            };

            $responseEmail = Utils::sendEmailSESPlain([
                "from" => "no-reply@marathon.edu.vn",
                "to" => [$templateData['email']],
                "subject" => $subject,
//                "htmlMessage" => $content,
                "date"  => Carbon::now(),
                "charSet" =>     "UTF-8",
                "bodyHtml" => $content,
            ]);

            $this->emailId = trim($responseEmail['id'],"<>");

            return self::returnError($responseEmail['error'],$responseEmail['message']);
        }
    }

    /**
     * @param array{phone: string, params: array} $templateData
     * @param ZaloTemplate $zaloTemplate
     * @return array
     */
    public function sendSmsTracking(array $templateData,ZaloTemplate $zaloTemplate): array{
        if(!$zaloTemplate->content_sms) return self::returnError(true,'content sms empty');

        $content = $zaloTemplate->content_sms;

        foreach ($templateData['params'] as $key => $value){
            $content = str_replace("<$key>",$value,$content);
        }
        $response = (new MarathonIntegrationService())->sendSmsPlaintext(Utils::phoneInternationalToLocal($templateData['phone']),$zaloTemplate->template_sms_id ?? 'SmsManual',$content,true);
        if(is_array($response)){
            $this->fptSmsId = $response['data']['MessageId'] ?? null;
            return ($response['status'] == 200) ? self::returnError() : self::returnError(true,$response['message'] ?? json_encode($response));
        }
        return self::returnError(!$response);
    }

    private function createTrackingNoti($data): void{
        $object_ids = ($data['object_ids']) ?? [];
        $i = 0;
        do{
            /** @var TrackingNotiSubscription $tracingNotification */
            $tracingNotification = TrackingNotiSubscription::newModelInstance([
                'channel' => $data['channel'],
                'channel_info' => $data['channel_info'],
                'channel_status' => $data['channel_status'],
                'content' => $data['content'],
                'status' => $data['status'],
                'reason' => $data['reason'],
                'object_type' => $data['object_type'],
                'object_id' => (!empty($object_ids)) ? (int)$object_ids[$i] : null,
                'fpt_sms_id' => $data['fpt_sms_id'] ?? null,
                'email_id' => $data['email_id'] ?? null,
                'zalo_template_id' => $data['zalo_template_id'] ?? 0
            ]);

            $tracingNotification->send_zns()->associate($this->zaloSendZNS ?? 0);
            $tracingNotification->student()->associate($this->student ?? Student::query()->find($data['student_id']));
            $doneSave = $tracingNotification->save();
            if($doneSave && $this->trackingTemporariesId){
                TrackingTemporary::query()->where('id',$this->trackingTemporariesId)->delete();
            }

            $i++;
        } while ($i < count($object_ids));
    }

    public function handleTrackingByEmail($channel,ZaloTemplate $zaloTemplate): array{
        $email = (!$this->student)
            ? $this->templateDataSendNotyObject->email
            : match ($zaloTemplate->communicate_related ?? null){
                ZaloTemplate::COMMUNICATED_TYPE_STUDENT => $this->student->email ?? null,
                ZaloTemplate::COMMUNICATED_TYPE_PARENT => $this->student->relative_email ?? null,
                default => null
            };

        $params = $this->templateDataSendNotyObject->params;
        if (!is_null($zaloTemplate->system_type) && $zaloTemplate->system_type == ZaloTemplate::SYSTEM_TYPE_LDB_REPORT){
            $params['link_ldb'].= $channel;
        }

        $responseSendZns = (filter_var($email,FILTER_VALIDATE_EMAIL))
            ? $this->sendEmailTracking(['email' => $email,'params' => $params],$zaloTemplate)
            : self::returnError(true,'email invalid');

        $content = (!$this->isRenewal) ? json_encode($params) : json_encode($this->emailRenewal);
        $this->createTrackingNoti([
            'channel' => $channel,
            'channel_info' => $email ?? null,
            'channel_status' => 'Đã gửi',
            'content' => $content,
            'status' => (!$responseSendZns['error']) ? null : 'Thất bại',
            'reason' => ($responseSendZns['error']) ? ($responseSendZns['message'] ?? null) : null,
            'object_type' => $this->templateDataSendNotyObject->objectType,
            'object_ids' => ($this->templateDataSendNotyObject->objectId) ? explode(',',$this->templateDataSendNotyObject->objectId) : null,
            'student_id' => $this->templateDataSendNotyObject->studentId,
            'email_id' => $this->emailId,
            'zalo_template_id' => $zaloTemplate->getKey() ?? 0
        ]);
        $this->emailId = null;

        return (!$responseSendZns['error']) ? self::returnError(false) : self::returnError(true);
    }

    public function handleTrackingByPhone($channel,ZaloTemplate $zaloTemplate): array{
        $phone = match ($channel){
            ChannelNotification::CHANNEL_ZALO => $this->student?->zalo_phone ?? $this->templateDataSendNotyObject->zaloPhone,

            ChannelNotification::CHANNEL_SMS => (!$this->student) ? $this->templateDataSendNotyObject->phone
                : match ($zaloTemplate->communicate_related){
                    ZaloTemplate::COMMUNICATED_TYPE_STUDENT => $this->student->phone_number,
                    ZaloTemplate::COMMUNICATED_TYPE_PARENT => $this->student->relative_phone,
                    default => null
                },

            default => null
        };

        $params = $this->templateDataSendNotyObject->params;
        if (!is_null($zaloTemplate->system_type) && $zaloTemplate->system_type == ZaloTemplate::SYSTEM_TYPE_LDB_REPORT){
            $params['link_ldb'].= $channel;
        }

        $data = [
            'phone' => $phone,
            'params' => $params,
            'object_id' => $this->templateDataSendNotyObject->objectId,
            'object_type' => $this->templateDataSendNotyObject->objectType
        ];

        $responseSendZns = ($phone) ? match ($channel){
            ChannelNotification::CHANNEL_ZALO => $this->sendZnsTrackingNoti($data, $zaloTemplate),
            ChannelNotification::CHANNEL_SMS => $this->sendSmsTracking($data, $zaloTemplate),
            default => self::returnError(true,null)
        } : self::returnError(true,'phone invalid');

        $this->createTrackingNoti([
            'channel' => $channel,
            'channel_info' => $phone ?? null,
            'channel_status' => 'Đã gửi',
            'content' => json_encode($params),
            'status' => (!$responseSendZns['error']) ? 'Thành công' : 'Thất bại',
            'reason' => ($responseSendZns['error']) ? ($responseSendZns['message'] ?? null) : null,
            'object_type' => $this->templateDataSendNotyObject->objectType,
            'object_ids' => ($this->templateDataSendNotyObject->objectId) ? explode(',',$this->templateDataSendNotyObject->objectId) : null,
            'student_id' => $this->templateDataSendNotyObject->studentId,
            'fpt_sms_id' => $this->fptSmsId,
            'zalo_template_id' => $zaloTemplate->getKey() ?? 0
        ]);
        $this->fptSmsId = null;

        return $responseSendZns;
    }

    public static function returnError(bool $isError = false,string $message = ''): array{
        return [
            'error' => $isError,
            'message' => ($isError) ? $message : null
        ];
    }
}

class templateDataSendNotyObject {
    public string|int|null  $studentId;

    public string|null      $phone;

    public string|int|null  $zaloPhone;

    public string|null      $email;

    public string|int|null  $templateId;

    public string|int|null  $objectId;

    public string|null      $objectType;

    public array            $params;

    public function __construct($studentId,$phone,$zaloPhone,$email,$templateId,$objectId,$objectType,$params)
    {
        $this->studentId = $studentId;
        $this->phone = $phone;
        $this->zaloPhone = $zaloPhone;
        $this->email = $email;
        $this->templateId = $templateId;
        $this->objectId = $objectId;
        $this->objectType = $objectType;
        $this->params = $params;
    }
}

class templateDataEmailRenewal {
    public  $from;
    public  $to;
    public  $subject;
    public  $courseName;
    public  $lineItemName;
    public  $dealId;
    public  $phoneNumber;
    public  $dealAmount;
    public  $subsRemain;

    public function __construct($from,$to,$subject,$courseName,$lineItemName,$dealId,$phoneNumber,$dealAmount,$subsRemain)
    {
        $this->from = $from;
        $this->to = $to;
        $this->subject = $subject;
        $this->courseName = $courseName;
        $this->lineItemName = $lineItemName;
        $this->dealId = $dealId;
        $this->phoneNumber = $phoneNumber;
        $this->dealAmount = $dealAmount;
        $this->subsRemain = $subsRemain;
    }
}
