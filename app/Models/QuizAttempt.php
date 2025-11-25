<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
        'total_questions',
        'correct_answers',
        'is_passed',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'is_passed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    // Calculate percentage score
    public function getPercentageScore(): float
    {
        if ($this->total_questions == 0) return 0;
        return round(($this->correct_answers / $this->total_questions) * 100, 2);
    }
}
