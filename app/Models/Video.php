<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'description',
        'video_url',
        'duration_seconds',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    // Get next video in the same module
    public function getNextVideo()
    {
        return Video::where('module_id', $this->module_id)
            ->where('order', '>', $this->order)
            ->orderBy('order')
            ->first();
    }

    // Get previous video in the same module
    public function getPreviousVideo()
    {
        return Video::where('module_id', $this->module_id)
            ->where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();
    }
}
