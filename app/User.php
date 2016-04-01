<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable =  ['username', 'office', 'type', 'role', 'email', 'password'];
}
