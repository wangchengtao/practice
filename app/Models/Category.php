<?php

namespace App\Models;

class Category extends Model
{
    protected $fillable = [
        'name', 'description',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class);
    }
}
