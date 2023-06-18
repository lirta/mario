<?php

namespace App\Models;


use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
        use Notifiable, HasFactory, HasRoles;
        protected $guard = 'admin';
        protected $guarded = ['id'];

        protected $fillable = [
            'username', 'email', 'password'
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];
}
