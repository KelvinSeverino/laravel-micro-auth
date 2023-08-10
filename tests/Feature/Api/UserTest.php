<?php

namespace Tests\Feature\Api;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_users_unathenticated(): void
    {
        $response = $this->getJson('/users');
        //$response->dump();
        $response->assertStatus(401);
    }

    public function test_get_users_unauthorized(): void
    {
        $user = User::factory()->create();
        $token = $user->createToken('test_device')->plainTextToken;

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->getJson('/users');

        $response->assertStatus(403);
    }

    public function test_get_users(): void
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test_device')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->getJson('/users');

        $response->assertStatus(200);
    }

    public function test_count_users(): void
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        User::factory()->count(10)->create();

        $user = User::first();
        $token = $user->createToken('test_device')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->getJson('/users');

        $response->assertJsonCount(10, 'data');
        $response->assertStatus(200);
    }

    public function test_get_fail_user(): void
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test_device')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->getJson("/users/fakeId");

        $response->assertStatus(404);
    }

    public function test_get_user(): void
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test_device')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->getJson("/users/{$user->uuid}");

        $response->assertStatus(200);
    }

    public function test_validations_store_user(): void
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test_device')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->postJson("/users", []);

        $response->assertStatus(422);
    }

    public function test_store_user(): void
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test_device')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->postJson("/users", [
                            'name' => 'Kelvin',
                            'email' => 'kelvin@email.com',
                            'password' => '12345678',
                        ]);

        $response->assertStatus(201);
    }

    public function test_validation_404_update_user(): void
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test_device')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->putJson("/users/fakeId", [
                            'name' => 'Kelvin',
                            'email' => 'kelvin@email.com',
                        ]);

        $response->assertStatus(404);
    }

    public function test_validations_update_user(): void
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test_device')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->putJson("/users/{$user->uuid}", [
                            'email' => 'kelvin@email.com',
                            'password' => '12345678',
                        ]);

        $response->assertStatus(422);
    }

    public function test_update_user(): void
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test_device')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->putJson("/users/{$user->uuid}", [
                            'name' => 'Kelvin Update',
                            'email' => 'kelvin@email.com',
                            'password' => '12345678',
                        ]);

        $response->assertStatus(201);
    }

    public function test_validation_404_delete_user(): void
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test_device')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->deleteJson("/users/fakeId");

        $response->assertStatus(404);
    }

    public function test_delete_user(): void
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test_device')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->deleteJson("/users/{$user->uuid}");

        $response->assertStatus(201);
    }
}
