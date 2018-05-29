<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */
    public function guestMayNotCreateThreads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->make();
        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function anAuthenticatedUserCanCreateNewForumThreads()
    {
        // given we have a signed in user
        $this->actingAs(factory('App\User')->create());

        // when we hit the endpoint to create a new thread
        $thread = factory('App\Thread')->make();
        $this->post('/threads', $thread->toArray());

        // then when we visit the thread page
        // we should see the new thread
        $this->get('/threads'. $thread->id)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
