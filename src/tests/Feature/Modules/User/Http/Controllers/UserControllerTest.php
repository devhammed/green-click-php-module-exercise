<?php

namespace Tests\Feature\Modules\User\Http\Controllers;

use Modules\User\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_visit_users()
    {
        $users = User::factory(10)->create();

        $response = $this->get('/users');

        $response->assertOk();

        $response->assertSee('All Users');

        foreach ($users as $user) {
            $response->assertSee($user->name);
            $response->assertSee($user->email);
        }
    }
}
