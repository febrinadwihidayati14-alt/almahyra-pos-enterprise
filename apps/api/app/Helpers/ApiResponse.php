<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(
        mixed $data = null,
        string $message = 'OK',
        int $status = 200
    ): JsonResponse {

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function created(
        mixed $data = null,
        string $message = 'Data berhasil dibuat.'
    ): JsonResponse {

        return self::success(
            $data,
            $message,
            201
        );
    }

    public static function updated(
        mixed $data = null,
        string $message = 'Data berhasil diperbarui.'
    ): JsonResponse {

        return self::success(
            $data,
            $message
        );
    }

    public static function deleted(
        string $message = 'Data berhasil dihapus.'
    ): JsonResponse {

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    public static function error(
        string $message,
        int $status = 400
    ): JsonResponse {

        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }

    public static function validation(
        array $errors
    ): JsonResponse {

        return response()->json([
            'success' => false,
            'message' => 'Validation Error',
            'errors' => $errors,
        ], 422);
    }
}