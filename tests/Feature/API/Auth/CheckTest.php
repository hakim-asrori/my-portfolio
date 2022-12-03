<?php

namespace Tests\Feature\API\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CheckTest extends TestCase
{
    /** @test */
    public function failed_check()
    {
        $this->getJson(route('api.auth.check'))->assertUnauthorized();
    }

    /** @test */
    public function success_check()
    {
        Sanctum::actingAs(User::find(1), ['logged']);
        $this->getJson(route('api.auth.check'))->assertOk();
    }
}
