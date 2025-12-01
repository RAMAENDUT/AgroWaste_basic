<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseModuleProgress extends Model
{
    use HasFactory;

    protected $table = 'course_module_progress';

    protected $fillable = [
        'user_id',
        'course_id',
        'course_module_id',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function courseModule()
    {
        return $this->belongsTo(CourseModule::class);
    }
}
