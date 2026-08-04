<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $service
    ) {}

    /**
     * Login
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->service->login(
            $request->validated()
        );

        return ApiResponse::success(
            [
                'token' => $result['token'],
                'user' => new UserResource($result['user']),
            ],
            'Login berhasil.'
        );
    }

    /**
     * Logout
     */
    public function logout(Request $request): JsonResponse
    {
        $this->service->logout(
            $request->user()
        );

        return ApiResponse::success(
            null,
            'Logout berhasil.'
        );
    }

    /**
     * Profile user
     */
    public function me(Request $request): JsonResponse
    {
        return ApiResponse::success(
            new UserResource($request->user()),
            'Data profile.'
        );
    }
}