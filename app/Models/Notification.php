<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'message',
        'type',
        'is_active',
        'scheduled_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'scheduled_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeScheduled($query)
    {
        return $query->where('scheduled_at', '<=', now())
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    public function scopeMaintenance($query)
    {
        return $query->where('type', 'maintenance');
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function isScheduled(): bool
    {
        return $this->scheduled_at && $this->scheduled_at->isFuture();
    }
}
