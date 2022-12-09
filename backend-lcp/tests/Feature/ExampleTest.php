<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_login()
    {
        $password = $this->faker->password();
        $user = User::create([
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'password' => Hash::make($password)
        ]);

        $data = [
            'email' => $user->email,
            'password' => $password
        ];

        $response = $this->post('/api/auth/login', $data);
        $response->assertSuccessful();
        $response->assertJsonStructure(['token']);
    }
}
