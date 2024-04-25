<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class LoginTest extends TestCase
{

    private function getParamsHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    /**
     * Test Login With data
     */
    public function testLoginWithData(): void
    {
        $payload = [
            'email' => fake()->email,
            'password' => fake()->password
        ];

        $user = User::factory()->create($payload);

        $response = $this->post('/api/login', $payload);

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Authorized');
    }

    /**
     * Test Login without data
     */
    public function testLoginWithoutData(): void
    {
        $payload = [
            'email' => fake()->email,
            'password' => fake()->password
        ];

        $user = User::factory()->create($payload);

        $response = $this->post('/api/login', [], $this->getParamsHeaders());


        $response->assertStatus(422)
            ->assertJsonPath('errors.email.0', 'The EMAIL field is mandatory.')
            ->assertJsonPath('errors.password.0', 'The PASSWORD field is mandatory.');
    }
}
