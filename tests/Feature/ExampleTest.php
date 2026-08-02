<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_logout_requires_post_and_ends_the_authenticated_session(): void
    {
        $user = $this->createUser();

        $this->actingAs($user)->get('/logout')->assertStatus(405);
        $this->actingAs($user)->post('/logout')->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_normal_users_cannot_access_admin_routes(): void
    {
        $this->actingAs($this->createUser())
            ->get('/admin-panel')
            ->assertForbidden();
    }

    public function test_a_user_cannot_cancel_another_users_booking(): void
    {
        $owner = $this->createUser();
        $otherUser = $this->createUser();
        $booking = $this->createBooking($owner);

        $this->actingAs($otherUser)
            ->post(route('bookings.cancel', $booking))
            ->assertRedirect();

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'pending',
        ]);
    }

    public function test_service_deletion_requires_delete_and_refuses_to_remove_booking_history(): void
    {
        $admin = $this->createUser(['isAdmin' => true]);
        $booking = $this->createBooking($this->createUser());
        $service = $booking->service;

        $this->actingAs($admin)->get(route('deleteService', $service))->assertStatus(405);
        $this->actingAs($admin)->delete(route('deleteService', $service))->assertRedirect();

        $this->assertDatabaseHas('services', ['id' => $service->id]);
        $this->assertDatabaseHas('bookings', ['id' => $booking->id]);
    }

    public function test_admin_cannot_accept_two_bookings_for_the_same_slot(): void
    {
        $admin = $this->createUser(['isAdmin' => true]);
        $service = $this->createService();
        $accepted = $this->createBooking($this->createUser(), $service, ['status' => 'accepted']);
        $pending = $this->createBooking($this->createUser(), $service);

        $this->actingAs($admin)
            ->post(route('admin.bookings.status', $pending), ['status' => 'accepted'])
            ->assertRedirect();

        $this->assertDatabaseHas('bookings', ['id' => $accepted->id, 'status' => 'accepted']);
        $this->assertDatabaseHas('bookings', ['id' => $pending->id, 'status' => 'pending']);
    }

    private function createUser(array $attributes = []): object
    {
        $userClass = implode(chr(92), ['App', 'Models', 'User']);

        return $userClass::factory()->create($attributes);
    }

    private function createService(): object
    {
        $serviceClass = implode(chr(92), ['App', 'Models', 'Service']);

        return $serviceClass::create([
            'title' => fake()->unique()->sentence(3),
            'image_url' => '/site/img/icon/icon-1.png',
            'description' => fake()->sentence(),
            'price' => 100,
            'isActive' => true,
        ]);
    }

    private function createBooking(object $user, ?object $service = null, array $attributes = []): object
    {
        $bookingClass = implode(chr(92), ['App', 'Models', 'Booking']);
        $service ??= $this->createService();

        return $bookingClass::create(array_merge([
            'name' => $user->name,
            'email' => $user->email,
            'service_id' => $service->id,
            'user_id' => $user->id,
            'booking_date' => now()->addDay()->toDateString(),
            'time_slot' => '09:00 AM',
            'service_price' => $service->price,
            'status' => 'pending',
        ], $attributes));
    }
}
