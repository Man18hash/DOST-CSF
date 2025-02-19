<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // ✅ Ensure this
use Illuminate\Notifications\Notifiable;

class AdminLogin extends Authenticatable
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];

    protected $guard = 'admin'; // ✅ Ensure this is set
}
