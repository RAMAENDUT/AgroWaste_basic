<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_module_id',
        'title',
        'passing_score',
    ];

    public function courseModule()
    {
        return $this->belongsTo(CourseModule::class);
    }

    public function questions()
    {
        return $this->hasMany(ExerciseQuestion::class)->orderBy('display_order');
    }
}
