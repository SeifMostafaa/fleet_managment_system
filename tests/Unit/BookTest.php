<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;

use App\Models\User;


class BookTest extends TestCase
{
    public function test_booking_without_authentication()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json',])->post('/api/book',[
                'start_station' => 'Cairo',
                'end_station' => 'Asyut',
                'trip_id' => 1
            ]);


        $response->assertStatus(401);
    }

    public function test_booking_happy_scenario()
    {
        // get user using user class
        $user = User::where('email', 'seif@robusta.com')->first();

        $token = $user->createToken('authToken')->plainTextToken;

        // add headers to the request
        $response = $this->json('POST', '/api/book', [
            'start_station' => 'Cairo',
            'end_station' => 'Luxor',
            'trip_id' => 4
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
    }

    public function test_booking_non_existing_trip()
    {
        // get user using user class
        $user = User::where('email', 'seif@robusta.com')->first();

        $token = $user->createToken('authToken')->plainTextToken;

        // add headers to the request
        $response = $this->json('POST', '/api/book', [
            'start_station' => 'Cairo',
            'end_station' => 'Mahala',
            'trip_id' => 1
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(404);
    }

    public function test_booking_no_available_seats()
    {
        // get user using user class
        $user = User::where('email', 'seif@robusta.com')->first();

        $token = $user->createToken('authToken')->plainTextToken;

        // add headers to the request
        $response = $this->json('POST', '/api/book', [
            'start_station' => 'Qena',
            'end_station' => 'El-Mansoura',
            'trip_id' => 1
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);
        // returns a message with "No available seats"
        $response->assertStatus(404);
    }

    public function test_booking_non_existing_trip_id()
    {
        // get user using user class
        $user = User::where('email', 'seif@robusta.com')->first();

        $token = $user->createToken('authToken')->plainTextToken;

        // add headers to the request
        $response = $this->json('POST', '/api/book', [
            'start_station' => 'Cairo',
            'end_station' => 'Asyut',
            'trip_id' => 120
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);
        // returns a message with "No available trip id"
        $response->assertStatus(404);
    }
}
