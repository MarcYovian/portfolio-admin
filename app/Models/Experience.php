<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'role',
        'company',
        'start_date',
        'end_date',
        'description',
        'achievements', // Menyimpan data JSON
    ];

    protected $casts = [
        'achievements' => 'array', // Mengubah kolom achievements menjadi array
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'experience_skills', 'experience_id', 'skill_id');
    }
}
