<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_content_id',
        'score',
        'total_questions',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function content()
    {
        return $this->belongsTo(CourseContent::class, 'course_content_id');
    }
}
