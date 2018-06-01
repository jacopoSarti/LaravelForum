<?php
/**
 * Created by PhpStorm.
 * User: jack
 * Date: 29/05/18
 * Time: 11:21 AM
 */

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    protected $thread;

    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function aThreadCanMakeAStringPath()
    {
        $thread = create('App\Thread');
        $this->assertEquals('/threads/' . $thread->channel->slug . '/' . $thread->id, $thread->path());
    }

    /** @test */
    public function aThreadHasACreator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    /** @test */
    public function aThreadHasReplies()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }

    /** @test */
    public function aThreadCanAddAReply()
    {
        $this->thread->addReply([
            'body' => "foobar",
            'user_id' => 1
        ]);
        $this->assertCount(1, $this->thread->replies);

    }

    /** @test */
    public function aThreadBelongsToAChannel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf( 'App\Channel', $thread->channel);
    }
}