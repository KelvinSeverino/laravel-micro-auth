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
}
