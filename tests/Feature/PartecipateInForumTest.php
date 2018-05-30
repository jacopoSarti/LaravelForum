<?php
/**
 * Created by PhpStorm.
 * User: jack
 * Date: 29/05/18
 * Time: 11:35 AM
 */

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PartecipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function anAuthenticatedUserMayPartecipateInForumThreads()
    {
        // given we have an authenticated user
        $user = create('App\User');
        $this->be($user);

        // and an existing thread
        $thread = create('App\Thread');

        // when the user adds a reply to the thread
        $reply = create('App\Reply');
        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());

        // then their reply should be visible on the page
        $this->get('/threads/' . $thread->id)
            ->assertSee($reply->body);
    }

    /** @test */
    public function anUnauthenticatedUserMayNotAddReplies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = create('App\Thread');
        $reply = create('App\User');
        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());

    }
}