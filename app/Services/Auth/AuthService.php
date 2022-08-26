<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Contracts\Auth\AuthServiceInterface;
use App\Services\Contracts\Auth\TokenFactoryInterface;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
    /**
     * Token factory instance.
     */
    protected TokenFactoryInterface $tokenFactory;

    /**
     * Initialize instances.
     *
     * @param TokenFactoryInterface $tokenFactory
     */
    public function __construct(TokenFactoryInterface $tokenFactory)
    {
        $this->tokenFactory = $tokenFactory;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function login(Request $request, array $credentials)
    {
        $credentials["remember_me"] = in_array("remember_me", $credentials) ?? false;

        if (
            !Auth::attempt([
                "email" => $credentials["email"], "password" => $credentials["password"]
            ], $credentials["remember_me"])
        ) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();

        if (!$user->hasVerifiedEmail()) {
            throw new Exception("User must verify its email.");
        }

        // Set token to pass and access it within UserResource
        $user->token = $this->tokenFactory->createToken($user);

        return $user;
    }

    /**
     * @inheritDoc
     */
    public function signup(Request $request, array $data)
    {
        $data["password"] = Hash::make($data["password"]);

        if ($user = User::create($data)) {

            event(new Registered($user));

            Auth::login($user);

            $user->token = $this->tokenFactory->createToken($user);

            return $user;
        }

        return false;
    }

    /**
     * @inheritDoc
     */
    public function logout()
    {
        Auth::logout();
    }
}
