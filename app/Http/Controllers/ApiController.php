<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
    public function __construct()
    {

    }

    public function JsonResponse($data,$error,$status = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => $data,
            'status' => $status,
            'error' => $error
        ],$status);
    }
}
