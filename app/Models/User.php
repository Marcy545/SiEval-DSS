<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
<<<<<<< HEAD
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
>>>>>>> master

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'rw_desa',
        'email',
        'password',
<<<<<<< HEAD
=======
        'role',
        'rw_desa',
>>>>>>> master
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
<<<<<<< HEAD
=======

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
>>>>>>> master
}