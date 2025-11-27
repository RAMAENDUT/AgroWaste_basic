<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
        'completed_at',
        'progress_percentage',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
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

    public function updateProgress()
    {
        $totalContents = $this->course->contents()->where('is_active', true)->count();
        
        if ($totalContents == 0) {
            $this->progress_percentage = 0;
            $this->save();
            return;
        }

        $completedContents = CourseContentProgress::where('user_id', $this->user_id)
            ->whereIn('course_content_id', $this->course->contents()->pluck('id'))
            ->where('is_completed', true)
            ->count();

        $this->progress_percentage = round(($completedContents / $totalContents) * 100);
        
        if ($this->progress_percentage >= 100) {
            $this->completed_at = now();
        }
        
        $this->save();
    }
}
