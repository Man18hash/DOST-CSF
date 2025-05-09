<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitProvider extends Model
{
    use HasFactory;

    // Replace 'category' with office_id
    protected $fillable = [
        'unit_name',
        'status',
        'office_id',
    ];

    /**
     * The office this unit belongs to.
     */
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id');
    }

    public function employees()
    {
        return $this->hasMany(DOSTEmployee::class, 'unit_provider_id');
    }
}
