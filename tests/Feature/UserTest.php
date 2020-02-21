<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_update()
    {
        $user = factory(User::class)->create();
        $user->phone = '597801133';

        $user2 = factory(User::class)->create();
        $this->actingAs($user2);

        $response = $this->json('post', "/api/users/update", [
                'id' => $user->id,
            ] + $user->toArray());

        $response->assertStatus(403);

        $response = $this->json('post', "/api/users/update", [
                'phone' => '5978011331',
            ] + $user2->toArray());

        $response->assertStatus(422);

        $response = $this->json('post', "/api/users/update", [
                'phone' => '597a01133',
            ] + $user2->toArray());

        $response->assertStatus(422);

        $response = $this->json('post', "/api/users/update", [
                'phone' => '297201133',
            ] + $user2->toArray());

        $response->assertStatus(422);

        $response = $this->json('post', "/api/users/update", [
                'phone' => '597801133',
            ] + $user2->toArray());

        $response->assertStatus(200);

        $response = $this->json('post', "/api/users/update", [
                'name' => 'vasia',
            ] + $user2->toArray());


        $response->assertStatus(200);

        $response = $this->json('post', "/api/users/update", [
                'name' => 'vasia',
                'email' => $user->email,
            ] + $user2->toArray());

        $response->assertStatus(422);

        $payload = [
            'id' => $user2->id,
            'name' => 'vasia',
            'phone' => '597801133',
            'email' => 'test@mail.ru',
        ];
        $response = $this->json('post', "/api/users/update", $payload);

        $response->assertStatus(200);

        $response->dump();

        $this->assertDatabaseHas('users', [
                'id' => $user2->id,
            ] + $payload);

    }
}
