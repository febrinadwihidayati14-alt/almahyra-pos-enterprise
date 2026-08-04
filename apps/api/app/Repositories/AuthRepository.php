<?php

namespace App\Repositories;

use App\Models\User;

class AuthRepository
{
    /**
     * Cari user berdasarkan email.
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Buat Sanctum token.
     */
    public function createToken(User $user): string
    {
        return $user->createToken('almahyra-pos')->plainTextToken;
    }

    /**
     * Hapus seluruh token user.
     */
    public function revokeTokens(User $user): void
    {
        $user->tokens()->delete();
    }
}