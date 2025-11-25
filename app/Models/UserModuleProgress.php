<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserModuleProgress extends Model
{
    protected $table = 'user_module_progress';

    protected $fillable = [
        'user_id',
        'module_id',
        'module_completed',
        'video_completed',
        'quiz_completed',
        'quiz_score',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'module_completed' => 'boolean',
        'video_completed' => 'boolean',
        'quiz_completed' => 'boolean',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    // Check if module is fully completed
    public function isFullyCompleted(): bool
    {
        return $this->module_completed && $this->video_completed && $this->quiz_completed;
    }

    // Calculate progress percentage
    public function getProgressPercentage(): int
    {
        $completed = 0;
        if ($this->module_completed) $completed++;
        if ($this->video_completed) $completed++;
        if ($this->quiz_completed) $completed++;
        
        return round(($completed / 3) * 100);
    }
}
