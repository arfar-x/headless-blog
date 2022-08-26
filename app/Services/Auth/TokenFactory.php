<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Contracts\Auth\TokenFactoryInterface;

/**
 * Do all the stuff about token generation
 */
class TokenFactory implements TokenFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createToken(User $user, string $key = null): string
    {
        $key = $key ?: request()->email;

        return $user->createToken($key)->plainTextToken;
    }

    /**
     * @inheritDoc
     */
    public function getCurrentToken(User $user)
    {
        return $user->currentAccessToken();
    }

    /**
     * @inheritDoc
     */
    public function getAllTokens(User $user)
    {
        return $user->tokens()->all()->toArray();
    }

    /**
     * @inheritDoc
     */
    public function deleteAllTokens(User $user)
    {
        $user->tokens()->delete();
    }

    /**
     * @inheritDoc
     */
    public function setToken(User $user, $token): self
    {
        $user->withAccessToken($token);

        return $this;
    }
}