<?php

namespace App\Services\Contracts\Auth;

use App\Services\Contracts\ServiceInterface;
use Illuminate\Http\Request;

interface AuthServiceInterface extends ServiceInterface
{
    /**
     * Login user with validated credentials
     *
     * @param Request $request
     * @param array $credentials
     * @return false|User
     */
    public function login(Request $request, array $credentials);

    /**
     * Signup the user with given data.
     *
     * @param Request $request
     * @param array $data
     * @return false|User
     */
    public function signup(Request $request, array $data);

    /**
     * Signout the user.
     *
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function logout();
}
