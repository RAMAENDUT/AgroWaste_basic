<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuizOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_quiz_question_id',
        'option_text',
        'is_correct',
        'order',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function question()
    {
        return $this->belongsTo(CourseQuizQuestion::class, 'course_quiz_question_id');
    }
}
