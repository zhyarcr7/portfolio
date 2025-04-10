<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    /**
     * Get the user that owns the conversation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the messages for the conversation.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get the latest message of the conversation.
     */
    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class)->latest();
    }

    /**
     * Check if the conversation has unread messages for the admin.
     */
    public function hasUnreadMessagesForAdmin()
    {
        if (!$this->last_read_admin_at) {
            return $this->messages()->where('is_admin', false)->exists();
        }

        return $this->messages()
            ->where('is_admin', false)
            ->where('created_at', '>', $this->last_read_admin_at)
            ->exists();
    }

    /**
     * Check if the conversation has unread messages for the user.
     */
    public function hasUnreadMessagesForUser()
    {
        if (!$this->last_read_user_at) {
            return $this->messages()->where('is_admin', true)->exists();
        }

        return $this->messages()
            ->where('is_admin', true)
            ->where('created_at', '>', $this->last_read_user_at)
            ->exists();
    }
} 