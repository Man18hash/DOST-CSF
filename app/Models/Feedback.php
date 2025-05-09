<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    // explicitly match the new table name
    protected $table = 'feedbacks';

    protected $fillable = [
        'name',
        'age',
        'sex',
        'address',
        'client_classification',
        'client_type',
        'date',
        'CC1',
        'CC2',
        'CC3',
        'office_id',
        'unit_provider',
        'assistance_availed',
        'DOST_employee',
        'SQD0',
        'SQD1',
        'SQD2',
        'SQD3',
        'SQD4',
        'SQD5',
        'SQD6',
        'SQD7',
        'SQD8',
        'suggestions',
        'recommendation',
    ];
}
