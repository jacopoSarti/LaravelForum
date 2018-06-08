<?php
/**
 * Created by PhpStorm.
 * User: jack
 * Date: 5/06/18
 * Time: 3:30 PM
 */

namespace App\Filters;


use Illuminate\Http\Request;
use App\User;

class ThreadFilters extends Filters
{
    protected $filters = ['by', 'popular'];
    /**
     * Filter the query by a given username
     * @param  string $username
     * @return mixed
     */
    public function by($username)
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query according to most popular threads.
     *
     * @return mixed
     */
    public function popular()
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }
}