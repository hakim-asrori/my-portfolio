<?php

namespace Tests\Feature\API\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    /** @test */
    public function failed_logout()
    {
        $this->postJson(route('api.auth.logout'))->assertUnauthorized();
    }

    /** @test */
    public function success_logout()
    {
        Sanctum::actingAs(User::find(1), ['logged']);
        $this->postJson(route('api.auth.logout'))->assertOk();
    }
}
