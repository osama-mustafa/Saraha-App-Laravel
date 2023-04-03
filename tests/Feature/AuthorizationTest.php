<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithSession;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Routing\Router;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{

    use RefreshDatabase, InteractsWithSession;
    public $user;
    public $admin;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            "name" => "test_user",
            "email" => "test_user@gmail.com",
            "password" => bcrypt("12345678")
        ]);

        $this->admin = User::factory()->create([
            "name" => "test_admin",
            "email" => "test_admin@gmail.com",
            "password" => bcrypt("12345678"),
            "is_admin" => true
        ]);
    }

    public function test_non_admin_user_cannot_access_messages_page_in_admin_dashboard()
    {
        $response = $this->actingAs($this->user)->get(route("messages"));
        $response->assertStatus(302);
    }

    public function test_non_admin_user_cannot_access_users_page_in_admin_dashboard()
    {
        $response = $this->actingAs($this->user)->get(route("users"));
        $response->assertStatus(302);
    }
}

