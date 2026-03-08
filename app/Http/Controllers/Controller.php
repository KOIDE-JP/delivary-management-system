<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function responseWithSuccess($data, $message, $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'status' => $code,
        ], $code);
    }
 
    public function responseWithError($data=null, $message, $code = 500): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => $data,
            'message' => $message,
            'status' => $code,
        ], $code);
    }
}
