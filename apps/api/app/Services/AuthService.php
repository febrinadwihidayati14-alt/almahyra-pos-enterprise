<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        protected AuthRepository $repository
    ) {}

    /**
     * Login user.
     *
     * @return array{
     *     token:string,
     *     user:User
     * }
     */
    public function login(array $credentials): array
    {
        $user = $this->repository->findByEmail(
            $credentials['email']
        );

        if (!$user) {

            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);

        }

        if (!Hash::check(
            $credentials['password'],
            $user->password
        )) {

            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);

        }

        $this->repository->revokeTokens($user);

        $token = $this->repository->createToken($user);

        return [

            'token' => $token,

            'user' => $user,

        ];
    }

    /**
     * Logout.
     */
    public function logout(User $user): void
    {
        $this->repository->revokeTokens($user);
    }
}