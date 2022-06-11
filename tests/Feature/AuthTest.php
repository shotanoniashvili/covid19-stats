<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserLoginsSuccessfully()
    {
        $user = User::factory()->create(['email' => 'test@test', 'password' => bcrypt('test')]);
        $credentials = ['email' => 'test@test', 'password' => 'test'];
        $this->json('POST', 'api/login', $credentials)
            ->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
                'token'
            ]);
        $user->delete();
    }

    public function testUserDataLoadsSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->json('GET', 'api/user')
            ->assertStatus(200)
            ->assertJsonStructure([
                'user' => [
                    'id',
                    'name',
                    'email',
                    'email_verified_at',
                    'created_at',
                    'updated_at'
                ]
            ]);
        $user->delete();
    }

    public function testUserLogoutsSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->json('POST', 'api/logout')
            ->assertStatus(200)
            ->assertExactJson([
                'message' => 'success'
            ]);
        $user->delete();
    }

}
