<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    private function getParamsHeaders()
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    /**
     * Test Register With data
     */
    public function testRegisterWithData(): void
    {
        $payload = [
            'name' => fake()->name,
            'email' => fake()->email,
            'password' => fake()->password
        ];

        $response = $this->post('/api/register', $payload);

        $response->assertStatus(200);
    }

    /**
     * Test Login without data
     */
    public function testRegisterWithoutData(): void
    {
        $payload = [
            'name' => fake()->name,
            'email' => fake()->email,
            'password' => fake()->password
        ];

        $response = $this->post('/api/register', [], $this->getParamsHeaders());

        $response->assertStatus(422)
            ->assertJsonPath('errors.email.0', 'The EMAIL field is mandatory.')
            ->assertJsonPath('errors.password.0', 'The PASSWORD field is mandatory.');
    }
}
