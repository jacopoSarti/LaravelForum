<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavouritesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function aGuestCannotFavoriteAnything()
    {
        $this->withExceptionHandling()
            ->post('replies/1/favourites')
            ->assertRedirect('/login');
    }

    /** @test */
    public function anAuthenticatedUserCanFavouriteAnyReply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        // If I post to a favourite endpoint
        $this->post('replies/' . $reply->id . '/favourites');

        // It should be recorded in the database
        $this->assertcount(1, $reply->favourites);
    }

    /** @test */
    public function anAuthenticatedUserMayFavouriteAReplyOnlyOnce()
    {
        $this->signIn();

        $reply = create('App\Reply');


        try{
            $this->post('replies/' . $reply->id . '/favourites');
            $this->post('replies/' . $reply->id . '/favourites');

        }catch(\Exception $e){
            $this->fail('Did not expect to insert the same record set twice');
        }

        $this->assertcount(1, $reply->favourites);
    }
}