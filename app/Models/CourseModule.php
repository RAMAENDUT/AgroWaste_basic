<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'type',
        'content_text',
        'video_path',
        'duration_seconds',
        'display_order',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function exercise()
    {
        return $this->hasOne(Exercise::class, 'course_module_id');
    }
}
