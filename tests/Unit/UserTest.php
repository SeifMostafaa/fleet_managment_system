<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;


class UserTest extends TestCase
{
    public function test_register_happy_scenario()
    {
        $response = $this->post('/api/register', [
            'name' => 'seif',
            'email' => Str::random(10) . '@robusta.com',
            'password' => 'password',
            'password_confirmation' => 'password'
            ]);

        $response->assertStatus(201);
    }

    public function test_register_existing_email()
    {
        $response = $this->post('/api/register', [
            'name' => 'seif',
            'email' => 'seif@robusta.com',
            'password' => 'password',
            'password_confirmation' => 'password'
            ]);

        $response->assertStatus(404);
    }
}
