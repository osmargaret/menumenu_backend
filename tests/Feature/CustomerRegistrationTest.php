<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_register_with_lagos_state()
    {
        $response = $this->postJson('/api/customer-register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'state_id' => 24, // Lagos
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email',
                'phone',
                'state_id',
                'city_id',
                'role'
            ],
            'token'
        ]);
    }

    public function test_customer_can_register_with_hi_route()
    {
        $response = $this->postJson('/api/hi/customer-register', [
            'name' => 'Test User',
            'email' => 'test2@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'state_id' => 24, // Lagos
        ]);

        $response->assertStatus(201);
    }
}