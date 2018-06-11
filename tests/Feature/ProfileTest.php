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

class ProfileTest extends TestCase
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
        $user = create('App\User');

        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->get('/profiles/' . $user->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}