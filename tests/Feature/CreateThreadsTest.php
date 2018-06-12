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

        $this->get('threads/create')
            ->assertRedirect('login');
    }

    /** @test */
    public function anAuthenticatedUserCanCreateNewForumThreads()
    {
        // given we have a signed in user
        $this->signIn();

        // when we hit the endpoint to create a new thread
        $thread = make('App\Thread');
        $response = $this->post('/threads', $thread->toArray());

        // then when we visit the thread page
        // we should see the new thread
        $this->get($response->headers->get('location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function aThreadRequiresATitle()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function aThreadRequiresABody()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function aThreadRequiresAValidChannel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function guestsCannotDeleteThreads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $response = $this->delete($thread->path());

        $response->assertRedirect('/login');
    }

    /** @test */
    public function aThreadCanBeDeleted()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id])
            ->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test */
    public function threadsMayOnlyBeDeletedByThoseWhoHavePermission()
    {
        // TODO: 
    }
    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}