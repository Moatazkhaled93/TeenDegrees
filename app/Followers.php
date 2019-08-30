<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Followers extends Model
{
    /**
    * The attributes that are mass assignable.
    *
    * @var array 
    */
    protected $fillable = [
        'follower_id','leader_id',
        ];
}
