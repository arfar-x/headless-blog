<?php

namespace Tests;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * Provides a user when acting as an authenticated user is needed.
 */
trait HasUser
{
    use RefreshDatabase;

    /**
     * User model.
     *
     * @var \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable
     */
    private $user;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->createUser();
    }

    /**
     * Create a user model to act as a valid user with its relations.
     *
     * @param array $data
     * @return void
     */
    public function createUser(array $data = [])
    {
        $data = $data ?: [
            'id' => fake()->randomDigitNotNull(),
            'name' => 'John Doe',
            'email' => 'john@domain.com',
            'password' => Hash::make("password")
        ];

        $this->user = User::factory()
            ->create($data);

        // Article::factory(10)->create(['user_id' => $this->user->id])->each(function ($article) {

        // });

        Article::factory(10)->create(['user_id' => $this->user->id]);

        return $this->user;
    }
}
