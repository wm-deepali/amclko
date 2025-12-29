<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'email',
        'name',
        'password',
        'phone',
        'address',
        'city',
        'zipcode',
        'state',
        'country',
        'user_role',
        'confirm_code',
        'account_confirm',
        'account_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
