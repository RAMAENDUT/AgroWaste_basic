<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizQuestion extends Model
{
    protected $fillable = [
        'quiz_id',
        'question',
        'points',
        'order',
    ];

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuizOption::class, 'question_id');
    }

    // Get correct option
    public function getCorrectOption()
    {
        return $this->options()->where('is_correct', true)->first();
    }

    // Check if option is correct
    public function isCorrectOption($optionId): bool
    {
        return $this->options()->where('id', $optionId)->where('is_correct', true)->exists();
    }
}
