<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User; // Make sure to use the correct namespace for your User model

class HttpTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_http(): void
    {
        // Test a basic GET request
        $response = $this->get('/');
        $response->assertStatus(200);

        // Create a user using Laravel's User factory
        $user = User::factory()->create();

        // Test a JSON API with user authentication
        $response = $this->actingAs($user)->json('GET', '/api/user');
        $response->assertStatus(200)->assertJson(['name' => $user->name]);

    

        // Test setting a cookie
        $response = $this->withCookie('color', 'blue')->get('/');
        $response->assertStatus(200);
    }
}
