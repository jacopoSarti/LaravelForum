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
        $this->withExceptionHandling();

        $this->post('/threads')
            ->assertRedirect('login');

        $this->get('/threads/create')
            ->assertRedirect('login');
    }

    /** @test */
    public function anAuthenticatedUserCanCreateNewForumThreads()
    {
        // given we have a signed in user
        $this->signIn();

        // when we hit the endpoint to create a new thread
        $thread = create('App\Thread');
        $this->post('/threads', $thread->toArray());

        // then when we visit the thread page
        // we should see the new thread
        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
