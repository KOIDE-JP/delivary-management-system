<?php

namespace App\Traits;

trait ApiResponseTrait
{
    /**
     * Success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseWithSuccess($data, $message, $code = 200): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => $message,
            'status' => $code,
        ], $code);
    }

    /**
     * Error response
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseWithError($data = null, $message, $code = 500): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => $data,
            'message' => $message,
            'status' => $code,
        ], $code);
    }
}
