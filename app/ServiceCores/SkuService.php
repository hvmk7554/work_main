<?php
namespace App\ServiceCores;

use App\Helpers\Utils;
use Exception;
use Illuminate\Support\Facades\Http;
use Throwable;

class SkuService{
    public string $domain;

    /**
     * @return SkuService
     */
    public static function make(): SkuService
    {
        return new self();
    }

    public function __construct()
    {
        $this->domain = config('app.services.sku_service');
    }

    private function sendPatch(string $path, array $data): \Illuminate\Http\Client\Response
    {
        return Http::patch($this->domain . $path, $data);
    }

    /**
     * @throws Exception
     */
    public function syncUpdateSkuByImport(string $filePath, int $actionTrackingId): array
    {
        try {
            $res = $this->sendPatch('/skus/update-from-file',[
                "filePath" => $filePath,
                'actionTrackingId' => $actionTrackingId
            ]);

            if ($res->status() != 200){
                throw new Exception($res->json());
            }

            return $res->json();
        } catch (Throwable $e) {
            throw new Exception($e->getMessage());
        }
    }
}
