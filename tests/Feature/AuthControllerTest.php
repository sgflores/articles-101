<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    public function test_auth_login_invalid_request()
    {
        $response = $this->postJson('api/auth/login');
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors'
        ]);
    }

    public function test_auth_login_invalid_credentials()
    {
        $response = $this->postJson('api/auth/login', [
            'email' => 'test@gmail.com',
            'password' => 'test'
        ]);
        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Invalid Credentials'
        ]);
    }

    public function test_auth_login_valid_credentials()
    {
        // user factory uses 'password' as the password
        $user = factory(User::class)->create();
        $response = $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user',
            'access_token',
        ]);
    }

    public function test_get_auth_user()
    {
        $user = factory(User::class)->create();
        $response = $this->passportActingAs($user)->getJson('api/auth/user');
        $response->assertStatus(200)
        ->assertJson([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }
}
