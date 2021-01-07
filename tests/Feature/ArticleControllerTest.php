<?php

namespace Tests\Feature;

use App\User;
use App\Client;
use App\Article;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
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
        $response = $this->getJson('api/article');
        $this->assertUnAuthenticated($response);
    }

    public function test_store_unauthenticated()
    {
        $response = $this->postJson('api/article');
        $this->assertUnAuthenticated($response);
    }

    public function test_update_unauthenticated()
    {
        $response = $this->putJson('api/article/1');
        $this->assertUnAuthenticated($response);
    }

    public function test_index()
    {
        $user = factory(User::class)->create();
        $response = $this->passportActingAs($user)->getJson('api/article?limit=1');
        $response->assertStatus(200)
        ->assertJsonStructure([
            'data',
            'meta',
            'links'
        ]);
    }

    public function test_index_sort_client_name_desc()
    {
        $user = factory(User::class)->create();
        for($i = 1; $i<=5; $i++) {
            $client = factory(Client::class)->create([
                'name' => "Client-${i}",
                'email' => "test${i}@gmail.com"
            ]);
            factory(Article::class)->create([
                'id' => $i,
                'client_id' => $client->id
            ]);
        }
        $response = $this->passportActingAs($user)->getJson(
            'api/article?limit=20&orderByColumn=clients.name&orderByValue=desc'
        );
        $response->assertStatus(200)
        ->assertJsonStructure([
            'data',
            'meta',
            'links'
        ]);
        // assert if sorted in descending order 5,4,3,2,1
        $data = $response->getData()->data;
        $dataIndex = 0;
        for($i = 5; $i>=1; $i--) {
            $this->assertEquals($data[$dataIndex++]->id, $i);
        }
    }

    public function test_store()
    {
        $user = factory(User::class)->create();
        $payload =  [
            'title' => $this->faker->paragraph,
            'body' => $this->faker->text,
            'required_word_count' => 1,
            'client_id' => factory(Client::class)->create()->id
        ];
        $response = $this->passportActingAs($user)->postJson('api/article', $payload);
        $response->assertStatus(201);
        $this->assertDatabaseHas('articles', $payload);
    }

    public function test_update()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();
        $article = factory(Article::class)->create([
            'title' => 'test-title',
            'body' => $this->faker->text,
            'required_word_count' => 1,
            'client_id' => $client->id
        ]);
        $newTitle = 'test-updated';
        $response = $this->passportActingAs($user)->putJson("api/article/{$article->id}", [
            'title' => $newTitle,
            'body' => $this->faker->text,
            'client_id' => $client->id
        ]);
        $response->assertStatus(200);
        $response->assertSeeText('successfully updated');
        $this->assertNotNull(Article::where('title', $newTitle)->first());
    }
}
