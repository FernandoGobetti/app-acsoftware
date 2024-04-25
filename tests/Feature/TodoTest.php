<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class TodoTest extends TestCase
{
    private function getParamsHeaders()
    {
        $user = User::factory()->create();
        $token = $user->createToken(Str::random(10))->plainTextToken;
        return [
            'Authorization' => "Bearer {$token}",
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ];
    }

    /**
     * Test Get All Todos
     * EndPoint /api/todo
     */
    public function testGetAllTodos(): void
    {
        $todo = Todo::factory(10)->create();

        $response = $this->withHeaders($this->getParamsHeaders())->getJson('/api/todo');

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data');
    }

    /**
     * Test Get All Todos Without Token
     * EndPoint /api/todo
     */
    public function testGetAllTodosWithoutToken(): void
    {
        $todo = Todo::factory(10)->create();

        $response = $this->getJson('/api/todo');

        $response->assertStatus(401)
            ->assertUnauthorized();
    }

    /**
     * Create a new Todo task With data
     * Endoint /api/todo
     */
    public function testCreateTodoWithData(): void
    {
        $payload = [
            "name" => fake()->word,
            "description" => fake()->sentence,
            "status" => fake()->randomElement(['Y', 'N'])
        ];

        $response = $this->withHeaders($this->getParamsHeaders())
            ->postJson('/api/todo', $payload);

        $response->assertStatus(200)
            ->assertJsonIsObject();
    }

    /**
     * Create a new Todo task Without data
     * Endoint /api/todo
     */
    public function testCreateTodoWithoutData(): void
    {
        $payload = [
            "name" => fake()->word,
            "description" => fake()->sentence,
            "status" => fake()->randomElement(['Y', 'N'])
        ];

        $response = $this->withHeaders($this->getParamsHeaders())
            ->postJson('/api/todo', []);

        $response->assertStatus(422)
            ->assertJsonPath('errors.name.0', 'The NAME field is mandatory.')
            ->assertJsonPath('errors.description.0', 'The DESCRIPTION field is mandatory.');
    }

    /**
     * Create a new Todo task Without Token
     * Endoint /api/todo
     */
    public function testCreateTodoWithoutToken(): void
    {
        $payload = [
            "name" => fake()->word,
            "description" => fake()->sentence,
            "status" => fake()->randomElement(['Y', 'N'])
        ];

        $response = $this->postJson('/api/todo', $payload);

        $response->assertStatus(401)
            ->assertUnauthorized();
    }


    /**
     * Show Todo With ID
     * Endoint /api/todo/{id}
     */
    public function testShowTodoWithId(): void
    {
        $todo = Todo::factory()->create();

        $response = $this->withHeaders($this->getParamsHeaders())
            ->getJson('/api/todo/'.$todo->id);

        $response->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJsonPath('data.identify', $todo->id)
            ->assertJsonPath('data.name', $todo->name)
            ->assertJsonPath('data.description', $todo->description)
            ->assertJsonPath('data.status', $todo->status);
    }

    /**
     * Show Todo With ID and Without Token
     */
    public function testShowTodoWithoutToken(): void
    {
        $todo = Todo::factory()->create();

        $response = $this->getJson('/api/todo/'.$todo->id);

        $response->assertStatus(401)
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated.');
    }


    /**
     * Update a Todo task With data
     * Endoint /api/todo
     */
    public function testUpdateTodoWithData(): void
    {
        $todo = Todo::factory()->create();

        $payload = [
            "name" => fake()->word,
            "description" => fake()->sentence,
            "status" => fake()->randomElement(['Y', 'N'])
        ];

        $response = $this->withHeaders($this->getParamsHeaders())
            ->patchJson('/api/todo/'.$todo->id, $payload);

        $response->assertStatus(200)
            ->assertJsonIsObject()
            ->assertJsonPath('data.identify', $todo->id)
            ->assertJsonPath('data.name', $payload['name'])
            ->assertJsonPath('data.description', $payload['description'])
            ->assertJsonPath('data.status', $payload['status']);
    }

    /**
     * Update a Todo task Without data
     * Endoint /api/todo
     */
    public function testUpdateTodoWithoutData(): void
    {
        $todo = Todo::factory()->create();

        $payload = [
            "name" => fake()->word,
            "description" => fake()->sentence,
            "status" => fake()->randomElement(['Y', 'N'])
        ];

        $response = $this->withHeaders($this->getParamsHeaders())
            ->patchJson('/api/todo/'.$todo->id);

        $response->assertStatus(422)
            ->assertJsonPath('errors.name.0', 'The NAME field is mandatory.')
            ->assertJsonPath('errors.description.0', 'The DESCRIPTION field is mandatory.');
    }

    /**
     * Update a Todo task Without Token
     * Endoint /api/todo
     */
    public function testUpdateTodoWithoutToken(): void
    {
        $todo = Todo::factory()->create();

        $payload = [
            "name" => fake()->word,
            "description" => fake()->sentence,
            "status" => fake()->randomElement(['Y', 'N'])
        ];

        $response = $this->patchJson('/api/todo/'.$todo->id, $payload);

        $response->assertStatus(401)
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated.');
    }


    /**
     * Delete a Todo task With data
     * Endoint /api/todo
     */
    public function testDeleteTodoWithData(): void
    {
        $todo = Todo::factory()->create();

        $response = $this->withHeaders($this->getParamsHeaders())
            ->deleteJson('/api/todo/'.$todo->id);

        $response->assertStatus(204)
            ->assertNoContent();
    }

    /**
     * Delete a Todo task Without Token
     * Endoint /api/todo
     */
    public function testDeleteTodoWithoutToken(): void
    {
        $todo = Todo::factory()->create();

        $response = $this->deleteJson('/api/todo/'.$todo->id);

        $response->assertStatus(401)
            ->assertUnauthorized()
            ->assertJsonPath('message', 'Unauthenticated.');
    }
}
