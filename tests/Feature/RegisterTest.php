<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{

    use RefreshDatabase;

    public function test_guest_user_can_register_account_successfully()
    {
        $response = $this->post(route("register"), [
            "name" => "test_user",
            "email" => "test_user@gmail.com",
            "password" => "12345678",
            "password_confirmation" => "12345678"
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route("home"));
        $this->assertDatabaseHas("users", [
            "email" => "test_user@gmail.com"
        ]);
    }

}
