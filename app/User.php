<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $timestamps = true;
    protected $fillable =  ['username', 'office', 'type', 'role', 'email', 'password'];
    protected $hidden = ['password'];
}
