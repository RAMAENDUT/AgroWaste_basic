<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'thumbnail',
        'level',
        'duration_minutes',
        'display_order',
        'is_published',
    ];

    public function modules()
    {
        return $this->hasMany(CourseModule::class);
    }

    public function enrollments()
    {
        return $this->hasMany(CourseEnrollment::class);
    }

    public function isEnrolledBy($userId)
    {
        return $this->enrollments()->where('user_id', $userId)->exists();
    }

    public function getEnrollmentFor($userId)
    {
        return $this->enrollments()->where('user_id', $userId)->first();
    }
}
