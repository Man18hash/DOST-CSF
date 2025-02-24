<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSetting extends Model
{
    use HasFactory;

    protected $fillable = ['fields'];

    protected $casts = [
        'fields' => 'array', // Automatically decode JSON into an array
    ];
}
