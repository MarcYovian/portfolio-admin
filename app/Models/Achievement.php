<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $fillable = [
        'title',
        'issuer',
        'date',
        'image_url',
        'description',
        'credential_url',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'achievement_tag');
    }
}
