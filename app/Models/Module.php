<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Module extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'order',
        'is_active',
        'thumbnail',
        'duration_minutes',
        'level',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($module) {
            if (empty($module->slug)) {
                $module->slug = Str::slug($module->title);
            }
        });
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class)->orderBy('order');
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function userProgress(): HasMany
    {
        return $this->hasMany(UserModuleProgress::class);
    }

    // Get first video
    public function getFirstVideo()
    {
        return $this->videos()->first();
    }

    // Get first quiz
    public function getFirstQuiz()
    {
        return $this->quizzes()->first();
    }
}
