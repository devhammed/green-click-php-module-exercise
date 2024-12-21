<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_visit_users()
    {
        $response = $this->get('/users');

        $response->assertOk();

        $response->assertSee('Users');
    }
}
