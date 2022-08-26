<?php

namespace App\Services\Contracts\Auth;

use App\Models\User;

interface TokenFactoryInterface
{
    /**
     * Create a new access token for user.
     *
     * @param User $user
     * @param string $key
     * @return string
     */
    public function createToken(User $user, string $key = null): string;

    /**
     * Get the current token which is being used.
     *
     * @param User $user
     * @return string
     */
    public function getCurrentToken(User $user);

    /**
     * Get all user's tokens.
     *
     * @param User $user
     * @return array
     */
    public function getAllTokens(User $user);

    /**
     * Delete all user's tokens.
     *
     * @param User $user
     * @return void
     */
    public function deleteAllTokens(User $user);

    /**
     * Set the current access token for the user.
     *
     * @param \Laravel\Sanctum\Contracts\HasAbilities $accessToken
     * @return $this
     */
    public function setToken(User $user, $token): self;
}