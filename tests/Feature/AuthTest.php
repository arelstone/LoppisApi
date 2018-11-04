<?php

namespace Tests\Feature;

use Faker\Factory as Faker;
use Tests\TestCase;
use \App\User;

class AuthTest extends TestCase
{
    public function testRegister()
    {

        $faker = Faker::create();
        $data = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => '!!foobar111',
        ];

        $response = $this->json('POST', '/api/register', $data);

        $response
            ->assertStatus(201)
            ->assertJsonStructure(['data' => ['token']]);
    }

    public function testLogin()
    {
        $faker = Faker::create();
        $userData = [
            'name' => $faker->name,
            'email' => $faker->email,
            'password' => \Hash::make('!!foobar111'),
        ];
        $user = new User();
        $user->fill($userData);
        $user->save();


        $data = [
            'email' => $userData['email'],
            'password' => '!!foobar111',
        ];

        $response = $this->json('POST', '/api/login', $data);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['data' => ['token']]);
    }
}
