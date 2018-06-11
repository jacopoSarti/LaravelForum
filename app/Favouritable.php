<?php
/**
 * Created by PhpStorm.
 * User: jack
 * Date: 9/06/18
 * Time: 8:58 PM
 */

namespace App;


trait Favouritable
{

    public function favourites()
    {
        return $this->morphMany(Favourite::class, 'favourited');
    }

    public function favourite($userId)
    {
        $attributes = ['user_id' => $userId];

        if (!$this->favourites()->where($attributes)->exists()) {
            return  $this->favourites()->create($attributes);
        }
    }

    public function isFavourited()
    {
        return !! $this->favourites->where('user_id', auth()->id())->count();
    }

    public function getFavouritesCountAttribute()
    {
        return $this->favourites->count();
    }
}