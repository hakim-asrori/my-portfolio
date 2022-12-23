<?php

namespace App\Http\Searches;

use App\Models\Document;
use Illuminate\Database\Eloquent\Model;

class DocumentSearch extends HttpSearch
{

    protected function passable()
    {
        return Document::query();
    }

    protected function filters(): array
    {
        return [];
    }

    protected function thenReturn($documentSearch)
    {
        return $documentSearch;
    }
}
