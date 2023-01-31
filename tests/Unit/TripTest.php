<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;

use App\Models\User;


class TripTest extends TestCase
{
    public function test_fetching_trips_without_authentication()
    {

        $response = $this->withHeaders([
            'Accept' => 'application/json',])->get('/api/trips',[
                'start_station' => 'Cairo',
                'end_station' => 'Asyut'
            ]);


        $response->assertStatus(401);
    }

    public function test_fetching_trips_happy_scenario()
    {
        // get user using user class
        $user = User::where('email', 'seif@robusta.com')->first();

        $token = $user->createToken('authToken')->plainTextToken;

        // add headers to the request
        $response = $this->json('GET', '/api/trips', [
            'start_station' => 'Cairo',
            'end_station' => 'Asyut'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
    }

    public function test_fetching_trips_non_existing_stations()
    {
        // get user using user class
        $user = User::where('email', 'seif@robusta.com')->first();

        $token = $user->createToken('authToken')->plainTextToken;

        // add headers to the request
        $response = $this->json('GET', '/api/trips', [
            'start_station' => 'Cairo',
            'end_station' => 'Mahala'
        ], [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(404);
    }
}
