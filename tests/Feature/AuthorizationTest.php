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

    use RefreshDatabase;
    public $user;
    public $admin;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = createUserForTesting("test_user", "test_user@gmail.com");
        $this->admin = createUserForTesting("test_admin", "test_admin@gmail.com", $is_admin = true);
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

    public function test_admin_can_access_users_page_in_admin_dashboard()
    {
        $response = $this->actingAs($this->admin)->get(route("users"));
        $response->assertStatus(200);
        $response->assertViewIs("admin.users.index");
        $response->assertSeeText("Users");
    }

    public function test_admin_can_access_messages_page_in_admin_dashboard()
    {
        $response = $this->actingAs($this->admin)->get(route("messages"));
        $response->assertStatus(200);
        $response->assertViewIs("admin.messages.index");
        $response->assertSeeText("Messages");
    }

    public function test_admin_can_access_deleted_messages_page_in_admin_dashboard()
    {
        $response = $this->actingAs($this->admin)->get(route("trashed.messages"));
        $response->assertStatus(200);
        $response->assertViewIs("admin.messages.deleted-messages");
        $response->assertSeeText("Deleted Messages");
    }
}

