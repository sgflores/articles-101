<?php

namespace Tests\Unit\Models;

use App\Client;
use App\Article;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;

class ClientTest extends TestCase
{
    public function test_articles_relationship()
    {
        $client = factory(Client::class)->create();
        $articles = factory(Article::class, 5)->create([
            'client_id' => $client->id
        ]);
        $this->assertInstanceOf(Collection::class, $client->articles);
        $this->assertCount(count($articles), $client->articles);
        $this->assertInstanceOf(Article::class, $client->articles[0]);
    }

    public function test_valid_filters()
    {
        $client = new Client();
        $validFilters = $client->_validFilters ?? [];
        foreach($validFilters as $column) { 
            $this->assertTrue(Schema::hasColumn($client->getTable(), $column));
        }
    }

    public function test_eager_loaded_relationships()
    {
        $client = factory(Client::class)->create();
        $articles = factory(Article::class, 5)->create([
            'client_id' => $client->id
        ]);
        $eagerLoaded = $client->_eagerLoadedOnIndex ?? [];
        foreach($eagerLoaded as $relation) {
            $this->assertNotNull($client->{$relation});
        }
    }

}
