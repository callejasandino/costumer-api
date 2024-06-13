<?php

// tests/Feature/CustomerTest.php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_customer_api()
    {
        $this->getJson('/api/customers')->assertStatus(401);
    }

    public function test_authenticated_user_can_create_customer()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $response = $this->postJson('/api/customers', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 30,
            'dob' => '1993-05-21',
            'email' => 'john@example.com',
        ]);

        $response->assertStatus(201);
    }

    // Add more tests for read, update, delete operations
}
