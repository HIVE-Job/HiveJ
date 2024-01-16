<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AdminTest extends TestCase
{
     

      /**
     * @test
     */
    public function it_can_store_new_admin(): void
    {
        $this->withoutMiddleware();
        $adminData = [
            'name' => 'Test Admin',
            'email' => 'testadmin12345@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->post(route('a.store_new_admin'), $adminData);

        $response->assertRedirect(route('a.admins'));
        $this->assertDatabaseHas('users', ['email' => 'testadmin12345@example.com']);
    }
}