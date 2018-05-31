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

        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function guestCannotSeeTheCreateThreadPage()
    {
        $this->withExceptionHandling()->get('/threads/create')
            ->assertRedirect('login');
    }

    /** @test */
    public function anAuthenticatedUserCanCreateNewForumThreads()
    {
        // given we have a signed in user
        $this->signIn();

        // when we hit the endpoint to create a new thread
        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());

        // then when we visit the thread page
        // we should see the new thread
        $this->get('/threads'. $thread->id)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
