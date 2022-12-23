<?php

namespace App\Http\Searches;

use App\Http\Searches\Filters\Project\Search;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;

class ProjectSearch extends HttpSearch
{

    protected function passable()
    {
        return Project::with(['documents']);
    }

    protected function filters(): array
    {
        return [
            Search::class
        ];
    }

    protected function thenReturn($projectSearch)
    {
        return $projectSearch;
    }
}
