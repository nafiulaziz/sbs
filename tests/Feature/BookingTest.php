<?php
// tests/Feature/BookingTest.php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_create_booking()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $service = Service::factory()->create(['status' => 'active']);
        
        Sanctum::actingAs($customer);

        $bookingData = [
            'service_id' => $service->id,
            'booking_date' => Carbon::now()->addDay()->toDateTimeString(),
            'notes' => 'Test booking notes',
        ];

        $response = $this->postJson('/api/bookings', $bookingData);

        $response->assertStatus(201)
                ->assertJson(['message' => 'Booking created successfully']);

        $this->assertDatabaseHas('bookings', [
            'user_id' => $customer->id,
            'service_id' => $service->id,
            'status' => 'pending',
        ]);
    }

    public function test_cannot_book_service_in_past()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $service = Service::factory()->create(['status' => 'active']);
        
        Sanctum::actingAs($customer);

        $response = $this->postJson('/api/bookings', [
            'service_id' => $service->id,
            'booking_date' => Carbon::now()->subDay()->toDateTimeString(),
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['booking_date']);
    }

    public function test_customer_can_view_own_bookings()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $otherCustomer = User::factory()->create(['role' => 'customer']);
        $service = Service::factory()->create();

        $customerBooking = Booking::factory()->create([
            'user_id' => $customer->id,
            'service_id' => $service->id,
        ]);

        $otherBooking = Booking::factory()->create([
            'user_id' => $otherCustomer->id,
            'service_id' => $service->id,
        ]);

        Sanctum::actingAs($customer);

        $response = $this->getJson('/api/bookings');

        $response->assertStatus(200)
                ->assertJsonCount(1, 'bookings')
                ->assertJsonPath('bookings.0.id', $customerBooking->id);
    }

    public function test_customer_can_cancel_own_booking()
    {
        $customer = User::factory()->create(['role' => 'customer']);
        $service = Service::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $customer->id,
            'service_id' => $service->id,
            'status' => 'pending',
        ]);

        Sanctum::actingAs($customer);

        $response = $this->patchJson("/api/bookings/{$booking->id}/cancel");

        $response->assertStatus(200)
                ->assertJson(['message' => 'Booking cancelled successfully']);

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled',
        ]);
    }
}