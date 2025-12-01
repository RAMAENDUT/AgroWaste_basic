<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'exercise_id',
        'question_text',
        'display_order',
    ];

    public function exercise()
    {
        return $this->belongsTo(Exercise::class);
    }

    public function options()
    {
        return $this->hasMany(ExerciseOption::class, 'question_id');
    }
}
