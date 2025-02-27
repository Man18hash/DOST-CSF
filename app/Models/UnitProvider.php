<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitProvider extends Model
{
    use HasFactory;

    protected $fillable = ['unit_name', 'status', 'category'];

    public function employees()
    {
        return $this->hasMany(DOSTEmployee::class, 'unit_provider_id');
    }
}

