<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model

{
    use HasFactory;

    const TYPE_DECISION    = 'decision';
    const TYPE_EXPIRATION  = 'expiration';
    const TYPE_CONFLIT     = 'conflit';
    const TYPE_MAINTENANCE = 'maintenance';
    const TYPE_MESSAGE     = 'message';
    const TYPE_INCIDENT    = 'incident';

    protected $fillable = [
        'user_id',
        'type',
        'titre',
        'contenu',
        'lien',
        'lu'
    ];

    protected $casts = [
        'lu' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get CSS class for the notification type
     */
    public function getTypeClass(): string
    {
        return match($this->type) {
            self::TYPE_DECISION    => 'primary',
            self::TYPE_EXPIRATION  => 'warning',
            self::TYPE_CONFLIT     => 'danger',
            self::TYPE_MAINTENANCE => 'info',
            self::TYPE_INCIDENT    => 'danger',
            default                => 'secondary',
        };
    }

    /**
     * Get Icon for the notification type
     */
    public function getTypeIcon(): string
    {
        return match($this->type) {
            self::TYPE_DECISION    => '✅',
            self::TYPE_EXPIRATION  => '⌛',
            self::TYPE_CONFLIT     => '⚠️',
            self::TYPE_MAINTENANCE => '🔧',
            self::TYPE_INCIDENT    => '🚨',
            self::TYPE_MESSAGE     => '📩',
            default                => '🔔',
        };
    }

    /**
     * Get the user that owns the notification
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('lu', false);
    }

    /**
     * Scope for read notifications
     */
    public function scopeRead($query)
    {
        return $query->where('lu', true);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        $this->update(['lu' => true]);
    }
}
