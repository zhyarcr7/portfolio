<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConversationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the conversation.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Conversation  $conversation
     * @return bool
     */
    public function view(User $user, Conversation $conversation)
    {
        // Admin can view any conversation
        if ($user->is_admin) {
            return true;
        }

        // User can only view their own conversations
        return $user->id === $conversation->user_id;
    }
} 