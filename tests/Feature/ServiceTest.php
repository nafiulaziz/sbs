<?php
// tests/Feature/ServiceTest.php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_view_active_services()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        
        Service::create([
            'name' => 'Active Service',
            'description' => 'Test description',
            'price' => 100.00,
            'status' => 'active',
            'duration_minutes' => 60,
        ]);

        Service::create([
            'name' => 'Inactive Service',
            'description' => 'Test description',
            'price' => 200.00,
            'status' => 'inactive',
            'duration_minutes' => 60,
        ]);

        Sanctum::actingAs($customer);

        $response = $this->getJson('/api/services');

        $response->assertStatus(200)
                ->assertJsonCount(1, 'services')
                ->assertJsonPath('services.0.name', 'Active Service');
    }

    public function test_admin_can_create_service()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($admin);

        $serviceData = [
            'name' => 'New Service',
            'description' => 'New service description',
            'price' => 150.00,
            'status' => 'active',
            'duration_minutes' => 90,
        ];

        $response = $this->postJson('/api/admin/services', $serviceData);

        $response->assertStatus(201)
                ->assertJson(['message' => 'Service created successfully']);

        $this->assertDatabaseHas('services', $serviceData);
    }

    public function test_customer_cannot_create_service()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        Sanctum::actingAs($customer);

        $response = $this->postJson('/api/admin/services', [
            'name' => 'New Service',
            'description' => 'Description',
            'price' => 100.00,
            'status' => 'active',
            'duration_minutes' => 60,
        ]);

        $response->assertStatus(403);
    }
}