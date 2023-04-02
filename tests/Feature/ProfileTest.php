<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    public $user;

    public function setUp() : void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_access_edit_profile_page()
    {
        $response = $this->actingAs($this->user)->get(route('edit.profile'));
        $response->assertSee("Edit Profile");
        $response->assertStatus(200);
    }
}
