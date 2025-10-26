<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'title',
        'description',
        'category',
        'feature_video',
        'price',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
        'google_schema',
    ];

    protected $casts = [
        'price' => 'decimal:2', 
        'google_schema' => 'array', 
    ];

    public function modules(): HasMany
    {
        return $this->hasMany(Module::class,'course_id');
    }
    
    public function contents(): HasMany
    {
        return $this->hasMany(Content::class,'course_id');
    }
}
