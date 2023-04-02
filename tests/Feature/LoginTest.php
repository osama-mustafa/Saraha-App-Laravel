<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    public $user;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            "name" => "test_user",
            "email" => "test_user@gmail.com",
            "password" => bcrypt("12345678") 
        ]);
    }

    public function test_user_can_login_successfully()
    {
        $response = $this->post(route("login"), [
            "email" => "test_user@gmail.com",
            "password" => "12345678"
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(302);
        $response->assertRedirect(route("home"));
    }
}
