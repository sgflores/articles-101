<?php

namespace Tests\Unit\Models;

use App\Client;
use App\Article;
use Tests\TestCase;
use Illuminate\Support\Facades\Schema;

class ArticleTEst extends TestCase
{
    public function test_client_relationship()
    {
        $client = factory(Client::class)->create();
        $article = factory(Article::class)->create([
            'client_id' => $client->id
        ]);
        $this->assertInstanceOf(Client::class, $article->client);
    }

    public function test_valid_filters()
    {
        $article = new Article();
        $validFilters = $article->_validFilters ?? [];
        foreach($validFilters as $column) { 
            $this->assertTrue(Schema::hasColumn($article->getTable(), $column));
        }
    }

    public function test_eager_loaded_relationships()
    {
        $client = factory(Client::class)->create();
        $article = factory(Article::class)->create([
            'client_id' => $client->id
        ]);
        $eagerLoaded = $article->_eagerLoadedOnIndex ?? [];
        foreach($eagerLoaded as $relation) {
            $this->assertNotNull($article->{$relation});
        }
    }

    public function test_related_sortable_columns()
    {
        $article = new Article();
        $relatedSortableColumns = $article->_relatedSortableColumns ?? [];
        $validRelatedSorter = ['relatedTable', 'relatedColumn', 'relatedPrimaryId', 'baseTable', 'baseForeignId'];
        foreach($relatedSortableColumns as $column) {
            foreach($column as $key => $value) {
                $this->assertTrue(in_array($key, $validRelatedSorter));
            }
        }
    }

}
