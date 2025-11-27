<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseQuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_content_id',
        'question',
        'order',
    ];

    public function content()
    {
        return $this->belongsTo(CourseContent::class, 'course_content_id');
    }

    public function options()
    {
        return $this->hasMany(CourseQuizOption::class)->orderBy('order');
    }
}
