<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivity extends Model
{
    protected $fillable = [
        'user_id',
        'activity_type',
        'activity_title',
        'activity_description',
        'course_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function getFormattedTimeAttribute()
    {
        $now = now();
        $diffInMinutes = floor($this->created_at->diffInMinutes($now));
        $diffInHours = floor($this->created_at->diffInHours($now));
        $diffInDays = floor($this->created_at->diffInDays($now));
        
        // If more than 7 days, show date format
        if ($diffInDays > 7) {
            return $this->created_at->format('d M Y');
        }
        
        // If less than 1 hour
        if ($diffInHours < 1) {
            if ($diffInMinutes < 1) {
                return 'Baru saja';
            }
            return $diffInMinutes . ' menit yang lalu';
        }
        
        // If less than 24 hours (same day or not)
        if ($diffInHours < 24) {
            return $diffInHours . ' jam yang lalu';
        }
        
        // If yesterday
        if ($this->created_at->isYesterday()) {
            return '1 hari yang lalu';
        }
        
        // If within 7 days
        if ($diffInDays > 0 && $diffInDays <= 7) {
            return $diffInDays . ' hari yang lalu';
        }
        
        return 'Baru saja';
    }
}
