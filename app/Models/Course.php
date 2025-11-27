<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'thumbnail',
        'level',
        'duration_hours',
        'order',
        'is_active',
    ];

    public function contents()
    {
        return $this->hasMany(CourseContent::class);
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
