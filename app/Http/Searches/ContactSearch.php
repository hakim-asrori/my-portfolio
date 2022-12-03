<?php

namespace App\Http\Searches;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Model;

class ContactSearch extends HttpSearch
{

    protected function passable()
    {
        return Contact::query();
    }

    protected function filters(): array
    {
        return [];
    }

    protected function thenReturn($contactSearch)
    {
        return $contactSearch;
    }
}
