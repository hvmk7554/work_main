<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Helpers\Utils;


class ExcelImport implements ToCollection
{
    public $header = [];
    public $data = [];
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        $headers = array();
        $payload = [];
        foreach($collection as $key=>$params) {
            if ($key == 0) {
                foreach ($params as $header) {
                    $headers[] = Str::lower(trim($header));
                }
                log::info("headers: ",  $headers);
                continue;
            }
            $template_data = [];
            foreach ($params as $keyContent => $content) {
                $template_data[$headers[$keyContent]] = trim($content);
            }
            $payload[] = $template_data;
        }

        $this->header = $headers;
        $this->data = $payload;
    }
}
