<?php

namespace Tests\Feature;

use App\User;
use App\Client;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    private function assertUnAuthenticated($response)
    {
        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthenticated.'
        ]);
    }

    public function test_index_unauthenticated()
    {
        $response = $this->getJson('api/client');
        $this->assertUnAuthenticated($response);
    }

    public function test_store_unauthenticated()
    {
        $response = $this->postJson('api/client');
        $this->assertUnAuthenticated($response);
    }

    public function test_update_unauthenticated()
    {
        $response = $this->putJson('api/client/1');
        $this->assertUnAuthenticated($response);
    }

    public function test_index()
    {
        $user = factory(User::class)->create();
        $response = $this->passportActingAs($user)->getJson('api/client?limit=1');
        $response->assertStatus(200)
        ->assertJsonStructure([
            'data',
            'meta',
            'links'
        ]);
    }

    public function test_store()
    {
        $user = factory(User::class)->create();
        $payload =  [
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ];
        $response = $this->passportActingAs($user)->postJson('api/client', $payload);
        $response->assertStatus(201);
        $this->assertDatabaseHas('clients', $payload);
    }

    public function test_update()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create([
            'name' => 'test-client',
            'email' => $this->faker->email
        ]);
        $newName = 'test-updated';
        $response = $this->passportActingAs($user)->putJson("api/client/{$client->id}", [
            'name' => $newName,
            'email' => $client->email
        ]);
        $response->assertStatus(200);
        $response->assertSeeText('successfully updated');
        $this->assertNotNull(Client::where('name', $newName)->first());
    }
}
