<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isInstanceOf;

class ControllerApi extends Controller
{
    private mixed $user;
    public function __construct(Request $req)
    {
        if (!isset($this->user)) {
            if (empty($req->header("Authorization"))) {
                return;
            }
            $encodedToken = str_replace("Bearer ", "", $req->header('Authorization'));
            if (empty($encodedToken)) {
                return;
            }
            list($header, $payload, $signature) = explode('.', $encodedToken);
            $this->user = json_encode(base64_decode($payload));
        }
    }

    public function getUser()
    {
        return isset($this->user) ? $this->user->User : null ;
    }

//    public function toResponse($status, $data, $message): array
//    {
//        if ($data instanceof Model::class) {
//            $data = $data->toArray();
//        }
//        return [
//            "status" => $status,
//            "data" => $data,
//            "message" => $message,
//        ];
//    }

}
