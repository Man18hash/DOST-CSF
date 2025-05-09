<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    // Mass-assignable fields
    protected $fillable = [
        'name',
        'status',
    ];

    // One Office has many Units
    public function unitProviders()
    {
        return $this->hasMany(UnitProvider::class);
    }
}
