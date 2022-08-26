<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Http\Resources\ErrorResource;
use App\Http\Resources\MessageResource;
use App\Http\Resources\UserResource;
use App\Services\Contracts\Auth\AuthServiceInterface;
use Throwable;

class AuthController extends Controller
{
    /**
     * Service instance.
     */
    protected AuthServiceInterface $service;

    /**
     * Initialize the service instance.
     *
     * @param AuthServiceInterface $service
     */
    public function __construct(AuthServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * Login user with given credentials.
     *
     * @param LoginRequest $request
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function login(LoginRequest $request)
    {
        try {

            $user = $this->service->login($request, $request->validated());

            return new UserResource($user);
        } catch (Throwable $error) {

            return new ErrorResource($error, 403);
        }
    }

    /**
     * Signup user with given data.
     *
     * @param SignupRequest $request
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function signup(SignupRequest $request)
    {
        try {

            $user = $this->service->signup($request, $request->validated());

            return (new UserResource($user))->response()->setStatusCode(201);
        } catch (Throwable $error) {

            return new ErrorResource($error);
        }
    }

    /**
     * Signout the user.
     *
     * @return Illuminate\Http\Resources\Json\JsonResource
     */
    public function logout()
    {
        try {

            $this->service->logout();

            return new MessageResource([
                "error" => false,
                "message" => "User signed out"
            ]);
        } catch (Throwable $error) {

            return new ErrorResource($error);
        }
    }
}
