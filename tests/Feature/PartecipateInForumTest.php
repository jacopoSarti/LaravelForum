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
        $this->signIn();

        // and an existing thread
        $thread = create('App\Thread');

        // when the user adds a reply to the thread
        $reply = create('App\Reply');
        $this->post($thread->path() . '/replies', $reply->toArray());

        // then their reply should be visible on the page
        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function anUnauthenticatedUserMayNotAddReplies()
    {
        $thread = create('App\Thread');
        $reply = create('App\User');
        $this->withExceptionHandling()
            ->post($thread->path() . '/replies', $thread->toArray())
            ->assertRedirect('login');

    }

    /** @test */
    public function aReplyRequiresABody()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}