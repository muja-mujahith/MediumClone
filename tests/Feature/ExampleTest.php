<?php

use App\Models\User;

it('returns a successful response', function () {
    // Create a test user
    $user = User::factory()->create();

    // Authenticated users are redirected to the posts feed
    $response = $this->actingAs($user)->get('/');

    $response->assertRedirect(route('posts.index'));
});
