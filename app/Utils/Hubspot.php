<?php
namespace App\Utils;

use Illuminate\Support\Facades\Http;

class Hubspot{
    public string $apiHost;
    public string $apiKey;
    public string $urlObject;

    public function __construct(string $urlObject)
    {
        $this->apiHost = config('app.hubspot.api_host');
        $this->apiKey = config('app.hubspot.api_key');
        $this->urlObject = $urlObject;
    }

    public static function contact(): Hubspot
    {
        return new self('/crm/v3/objects/contacts');
    }

    public function getById(int $id,array $properties = []){
        $propertyParams = 'properties=firstname';
        foreach ($properties as $property){
            $propertyParams .= ','.$property;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->apiKey
        ])->get($this->apiHost.$this->urlObject."/".$id."?".$propertyParams);
        return $response->json();
    }

    public function getByPhone(string $phone,array $properties = []){

        $data = [
            "filterGroups" => [
                [
                    "filters" => [
                        [
                            "operator" => "EQ",
                            "propertyName" => "phone",
                            "value" => $phone
                        ],
                    ]
                ],
            ],
            "properties" => $properties,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer '.$this->apiKey,
            'Content-Type' => 'application/json'
        ])->post($this->apiHost.$this->urlObject."/search",$data);
        return $response->json();
    }



    public function response($haveError){
        return [
            'error' => $haveError
        ];
    }
}
