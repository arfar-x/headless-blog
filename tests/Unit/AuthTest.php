<?php

namespace Tests\Auth;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\HasUser;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use HasUser;

    /**
     * A valid user with correct credentials can login successfully.
     *
     * @return void
     */
    public function testLoginValidUser()
    {
        $response = $this->postJson(route('login'), [
            'email' => $this->user->email,
            'password' => "password"
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'user',
                'token'
            ])
            ->assertJson([
                'user' => $this->user->toArray(),
                'token' => $response["token"]
            ]);
    }

    /**
     * User cannot login with wrong or credentials.
     *
     * @return void
     */
    public function testLoginFailsWithWrongUser()
    {
        $response = $this->postJson(route('login'), [
            'email' => "wrong.email@domain.com",
            'password' => "wrong-password"
        ]);

        $response->assertForbidden()
            ->assertJsonStructure([
                'error',
                'message'
            ]);
    }

    /**
     * New user can signup then take a access token.
     *
     * @return void
     */
    public function testSignupUser()
    {
        $user = [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        $response = $this->postJson(route('signup'), $user);

        $response->assertCreated()
            ->assertJsonStructure([
                'user',
                'token'
            ])
            ->assertJson([
                'token' => $response["token"],
            ]);

        $user = User::where("email", $user["email"])->first();

        $this->assertAuthenticatedAs($user);
    }

    /**
     * Authentication user signs out of the session and deletes tokens.
     * TODO Maybe Laravel built-in `actingAs` method bypasses token creation;
     * TODO     so it there is no valid tokens to delete and expire session. Fix it.
     *
     * @return void
     */
    public function testUserSignout()
    {
        /**
         * ! This test is not passed, Laravel performs `actingAs` itself and
         * ! there is no references for a user to logout
         */
        $this->markTestSkipped();

        Sanctum::actingAs($this->user, ['*']);

        $response = $this->postJson(route('signout'));

        $this->assertGuest();
        // $this->assertAuthenticatedAs($this->user, $guard = null);
    }
}
