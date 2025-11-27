<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'type',
        'title',
        'description',
        'content',
        'video_url',
        'duration_seconds',
        'order',
        'is_active',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function progress()
    {
        return $this->hasMany(CourseContentProgress::class);
    }

    public function quizQuestions()
    {
        return $this->hasMany(CourseQuizQuestion::class)->orderBy('order');
    }

    public function isCompletedBy($userId)
    {
        return $this->progress()->where('user_id', $userId)->where('is_completed', true)->exists();
    }

    public function getProgressFor($userId)
    {
        return $this->progress()->where('user_id', $userId)->first();
    }
}
