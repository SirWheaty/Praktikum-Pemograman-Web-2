<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_create_posts(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('post.create'))->assertForbidden();
        $this->actingAs($user)->post(route('post.store'), [
            'title' => 'Unauthorized post',
            'body' => 'This should not be saved.',
        ])->assertForbidden();

        $this->assertDatabaseMissing('posts', ['title' => 'Unauthorized post']);

        $admin = User::factory()->create();
        $admin->forceFill(['role' => 'admin'])->save();

        $this->actingAs($admin)->get(route('post.create'))->assertOk();
        $this->actingAs($admin)->post(route('post.store'), [
            'title' => 'Admin post',
            'body' => 'This post is saved.',
        ])->assertRedirect(route('post.show', 'admin-post'));

        $this->assertDatabaseHas('posts', [
            'user_id' => $admin->id,
            'slug' => 'admin-post',
        ]);
    }

    public function test_my_profile_page_requires_login_and_displays_logged_in_user(): void
    {
        $this->get(route('post.profile-saya'))->assertRedirect(route('login'));

        $user = User::factory()->create(['name' => 'Ayu Login']);

        $this->actingAs($user)
            ->get(route('post.profile-saya'))
            ->assertOk()
            ->assertSee('Ayu Login')
            ->assertSee($user->email);
    }

    public function test_posts_are_visible_and_authored_posts_appear_on_my_profile(): void
    {
        $user = User::factory()->create();
        $post = $user->posts()->create([
            'title' => 'Public post',
            'slug' => 'public-post',
            'body' => 'Post content.',
        ]);

        $this->get(route('post.index'))->assertOk()->assertSee('Public post');
        $this->get(route('post.show', $post))->assertOk()->assertSee('Post content.');
        $this->actingAs($user)
            ->get(route('post.profile-saya'))
            ->assertOk()
            ->assertSee('Public post');
    }
}
