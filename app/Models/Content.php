<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Content extends Model
{
    protected $fillable = [
        'course_id',
        'module_id',
        'title',
        'type',
        'video_url',
        'duration',
    ];
    
    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class,'module_id','id');
    }
}
