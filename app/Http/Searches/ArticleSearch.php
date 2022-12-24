<?php

namespace App\Http\Searches;

use App\Models\Article;
use Illuminate\Database\Eloquent\Model;

class ArticleSearch extends HttpSearch
{

    protected function passable()
    {
        return Article::with(['documents']);
    }

    protected function filters(): array
    {
        return [];
    }

    protected function thenReturn($articleSearch)
    {
        return $articleSearch;
    }
}
