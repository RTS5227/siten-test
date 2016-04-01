<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable =  ['uid', 'office', 'type', 'role', 'email', 'password'];
}
