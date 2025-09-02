<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'degree',
        'institution',
        'start_date',
        'end_date',
        'description',
        'gpa',
        'max_gpa',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'gpa' => 'float',
        'max_gpa' => 'float',
    ];
}
