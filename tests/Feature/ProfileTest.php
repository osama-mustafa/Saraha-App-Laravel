<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    public $user;
    public $message;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->message = Message::factory()->create([
            "body"    => "test private message sent to this user",
            "user_id" => $this->user->id
        ]);
    }

    public function test_authenticated_user_can_access_edit_profile_page()
    {
        $response = $this->actingAs($this->user)->get(route('edit.profile'));
        $response->assertSee("Edit Profile");
        $response->assertStatus(200);
    }

    public function test_authenticated_user_can_access_change_password_page()
    {
        $response = $this->actingAs($this->user)->get(route('change.password'));
        $response->assertSee("Change Password");
        $response->assertStatus(200);
    }

    public function test_user_can_delete_his_own_received_message()
    {
        $response = $this->actingAs($this->user)
            ->delete(route("user.delete.message", $this->message->id));
        $response->assertStatus(302);
        $this->assertSoftDeleted($this->message);
    }
}
