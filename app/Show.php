<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    // public $timestamps = false;
    protected $fillable = ['show_name','genre','imdb_rating','lead_actor'];
}
