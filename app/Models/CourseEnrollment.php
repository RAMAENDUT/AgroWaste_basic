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
        'progress_percent',
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
        $totalContents = CourseModule::where('course_id', $this->course_id)->count();
        
        if ($totalContents == 0) {
            $this->progress_percent = 0;
            $this->save();
            return;
        }

        // TODO: implement module progress tracking
        $completedContents = 0;

        $this->progress_percent = round(($completedContents / $totalContents) * 100);
        
        if ($this->progress_percent >= 100) {
            $this->completed_at = now();
        }
        
        $this->save();
    }
}
