<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'category_id'];

    public function category()
    {
        return $this->belongsTo(SkillCategory::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_skills', 'skill_id', 'project_id');
    }

    public function experiences()
    {
        return $this->belongsToMany(Experience::class, 'experience_skills', 'skill_id', 'experience_id');
    }
}
