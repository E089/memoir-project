<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['username', 'email', 'password'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($user) {
    //         if (isset($user->password)) {
    //             $user->password = bcrypt($user->password);
    //         }
    //     });
    // }
}

