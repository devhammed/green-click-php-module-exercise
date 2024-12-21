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

    public function test_it_can_enable_user()
    {
        // Use the factory to create a user with 'enabled' set to false
        $user = User::factory()->disabled()->create();

        // Act: Make the request to enable the user
        $response = $this->post("/users/enable/{$user->id}");

        // Assert: Check if the response is successful and contains the expected keys and values in the JSON response
        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'enabled' => true,
            ]
        ]);

        // Verify the database update
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'enabled' => true,  // Assert that the user's 'enabled' field is now true
        ]);
    }

    public function test_it_can_disable_user()
    {
        // Use the factory to create a user with 'enabled' set to true
        $user = User::factory()->enabled()->create();

        // Act: Make the request to disable the user
        $response = $this->post("/users/disable/{$user->id}");

        // Assert: Check if the response is successful and contains the expected keys and values in the JSON response
        $response->assertOk();
        $response->assertJson([
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'enabled' => false,
            ]
        ]);

        // Verify the database update
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'enabled' => false,  // Assert that the user's 'enabled' field is now false
        ]);
    }

    public function test_it_returns_error_if_user_not_found_when_enabling()
    {
        $response = $this->post('/users/enable/9999'); // Non-existent user ID

        // Assert: Check if the response returns a 404 status for not found
        $response->assertNotFound();
    }

    public function test_it_returns_error_if_user_not_found_when_disabling()
    {
        $response = $this->post('/users/disable/9999'); // Non-existent user ID

        // Assert: Check if the response returns a 404 status for not found
        $response->assertNotFound();
    }
}
