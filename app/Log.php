<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    public $timestamps = true;
    protected $fillable = array('actor', 'action');
}
