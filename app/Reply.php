<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Favouritable;

class Reply extends Model
{
    use Favouritable, RecordsActivity;

    protected $guarded = [];

    protected $with = ['owner', 'favourites'];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
