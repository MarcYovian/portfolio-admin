<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'achievement_tag');
    }
}
