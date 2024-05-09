<?php

namespace App\Console\Commands\Notification\PreClassNotification;

use App\Services\NotificationService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use League\Csv\Reader;

class Send extends Command
{
    protected $signature = 'notification:pre-class-notification:send';

    protected $description = 'Command description';

    private const NOTICE_PERIOD_IN_MINUTE = 30;

    /**
     * @throws \League\Csv\Exception
     */
    public function handle(): int
    {
        list($dayOfWeek, $minuteOfDay) = $this->getCurrentDateTime();

        // TODO: Remove this example code.
        // $dayOfWeek = 5; // Friday
        // $minuteOfDay = 1200; // 20:00

        $classes = $this->getClasses();
        $classes = $this->filterClassesWithDateTime($classes, $dayOfWeek, $minuteOfDay);
        if (count($classes) < 1) {
            Log::info('Not found class to send notification.');
            return 0;
        }

        $subscriptions = $this->getSubscriptions();
        if (count($subscriptions) < 1) {
            Log::info('Not found subscription to send notification.');
            return 0;
        }

        foreach ($classes as $class) {
            $filteredSubscriptions = $this->filterSubscriptionsWithClass($subscriptions, $class);
            if (count($filteredSubscriptions) < 1) {
                Log::info(sprintf('Not found subscription for class %s to send notification.', $class['classin_id']));
                continue;
            }

            // TODO: Remove this double-check code.
            $filteredSubscriptions[] = [
                'classin_id' => -1,
                'classin_course_id' => $class['classin_id'],
                'phone_number' => '0398413480',
            ];

            foreach ($filteredSubscriptions as $subscription) {
                $className = sprintf('Lop %s %s - %s', $class['subject'], $class['grade'], $class['teacher']);
                $startHour = floor($minuteOfDay / 60);
                $startMinute = $minuteOfDay % 60;

                $content = sprintf('%s tai Marathon se dien ra luc %d:%d. Hay vao hoc dung gio nhe!', Str::ascii($className), $startHour, $startMinute);
                $phoneNumber = $subscription['phone_number'];
                $type = 'preClassNotification';

                resolve(NotificationService::class)->sendSMS($phoneNumber, $type, $content);
            }
        }

        return 0;
    }

    /**
     * @throws \League\Csv\Exception
     */
    private function getClasses(): array
    {
        $output = [];

        $path = realpath(__DIR__ . '/preclassnotification-classes.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv->getRecords() as $record) {
            if (isset($record['classin_id']) != true) {
                $this->warn('Class doesn\'t have `classin_id` value.');
                continue;
            }

            $startDate = Carbon::make($record['start_date']);
            $endDate = Carbon::make($record['end_date']);

            if ($startDate > Carbon::now() || $endDate < Carbon::now()) {
                $this->warn(sprintf('Class %s is not started yet or ended already.', $record['classin_id']));
                continue;
            }

            $output[] = [
                'classin_id' => $record['classin_id'],
                'subject' => $record['subject'],
                'grade' => $record['grade'],
                'teacher' => $record['teacher'],
                'day_of_week' => $record['day_of_week'],
                'start_time' => $record['start_time'],
                'start_date' => $startDate,
                'end_date' => $endDate,
            ];
        }

        return $output;
    }

    private function filterClassesWithDateTime(array $classes, int $dayOfWeek, int $minuteOfDay): array
    {
        $output = [];

        foreach ($classes as $class) {
            if ($class['day_of_week'] == $dayOfWeek && $class['start_time'] == $minuteOfDay) {
                $output[] = $class;
            }
        }

        return $output;
    }

    /**
     * @throws \League\Csv\Exception
     */
    private function getSubscriptions(): array
    {
        $output = [];

        $path = realpath(__DIR__ . '/preclassnotification-subscriptions.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv->getRecords() as $record) {
            $output[] = [
                'classin_id' => $record['classin_id'],
                'classin_course_id' => $record['classin_course_id'],
                'phone_number' => $record['phone_number'],
            ];
        }

        return $output;
    }

    private function filterSubscriptionsWithClass(array $subscriptions, array $class): array
    {
        $output = [];

        foreach ($subscriptions as $subscription) {
            if ($subscription['classin_course_id'] == $class['classin_id']) {
                $output[] = $subscription;
            }
        }

        return $output;
    }

    private function getCurrentDateTime(): array
    {
        $now = \Carbon\Carbon::now();
        $dayOfWeek = $now->dayOfWeek;
        $hour = $now->hour;
        $minute = $now->minute;

        $minuteOfDay = $hour * 60 + $minute;
        $minuteOfDay = $minuteOfDay + self::NOTICE_PERIOD_IN_MINUTE;

        return [$dayOfWeek, $minuteOfDay];
    }
}
