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
        $user = factory('App\User')->create();
        $this->be($user);

        // and an existing thread
        $thread = factory('App\Thread')->create();

        // when the user adds a reply to the thread
        $reply = factory('App\Reply')->create();
        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());

        // then their reply should be visible on the page
        $this->get('/threads/' . $thread->id)
            ->assertSee($reply->body);
    }

    /** @test */
    public function anUnauthenticatedUserMayNotAddReplies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->create();
        $reply = factory('App\User')->create();
        $this->post('/threads/' . $thread->id . '/replies', $reply->toArray());

    }
}