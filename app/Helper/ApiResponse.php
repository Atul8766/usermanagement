<?php


namespace App\Helper;


class ApiResponse
{

    /**
     * @param string $status
     * @param null $message
     * @param array $data
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success($status = 'success', $message = null, $data = [], $statusCode = 200)
    {
        return response()->json([
            'success' => $status,
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * @param string $status
     * @param null $message
     * @param int $statusCode
     * @return \Illuminate\Http\JsonResponse
     */
    public static function error($status = 'error', $message = null, $statusCode = 500)
    {
        error_log($statusCode);
        return response()->json([
            'success' => $status,
            'message' => $message,
        ], $statusCode);
    }
}
