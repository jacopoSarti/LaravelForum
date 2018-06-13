<?php
/**
 * Created by PhpStorm.
 * User: jack
 * Date: 9/06/18
 * Time: 9:24 PM
 */

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aUserHasAProfile()
    {
        $user = create('App\User');

        $this->get('/profiles/' . $user->name)
        ->assertSee($user->name);
    }

    /** @test */
    public function aProfileDisplayAllThreadsCreatedByTheAssociatedUser()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->get('/profiles/' . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }
}