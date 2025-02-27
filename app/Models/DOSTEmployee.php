<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DOSTEmployee extends Model
{
    use HasFactory;

    protected $table = 'dost_employees';
    protected $fillable = ['name', 'employee_id', 'unit_provider_id', 'status']; // ✅ Added employee_id and status

    public function unitProvider()
    {
        return $this->belongsTo(UnitProvider::class, 'unit_provider_id');
    }
}


