<?php
// app/Models/DOSTEmployee.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DOSTEmployee extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'dost_employees';

    // Mass‐assignable fields
    protected $fillable = [
        'name',
        'employee_id',
        'unit_provider_id',
        'status',
    ];

    /**
     * Each DOSTEmployee belongs to a UnitProvider.
     */
    public function unitProvider()
    {
        return $this->belongsTo(UnitProvider::class, 'unit_provider_id');
    }
}
