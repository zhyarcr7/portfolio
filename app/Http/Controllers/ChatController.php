<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewMessageNotification;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display a list of conversations.
     * If the user is an admin, show all conversations.
     * If the user is not an admin, show only their conversations.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->is_admin) {
            // Admin sees all conversations, ordered by last message
            $conversations = Conversation::with(['user', 'latestMessage'])
                ->orderBy('last_message_at', 'desc')
                ->get();
        } else {
            // Regular user sees only their conversations
            $conversations = $user->conversations()
                ->with(['latestMessage'])
                ->orderBy('last_message_at', 'desc')
                ->get();
        }

        return view('chat.index', compact('conversations'));
    }

    /**
     * Show the conversation.
     */
    public function show(Conversation $conversation)
    {
        // Check if the user is authorized to view this conversation
        if (Auth::user()->id !== $conversation->user_id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        // Mark messages as read based on who is viewing
        if (Auth::user()->is_admin) {
            $conversation->messages()
                ->where('is_admin', false)
                ->where('is_read', false)
                ->update(['is_read' => true]);
                
            // Update the timestamp for admin viewing messages
            $conversation->last_read_admin_at = now();
            $conversation->save();
        } else {
            $conversation->messages()
                ->where('is_admin', true)
                ->where('is_read', false)
                ->update(['is_read' => true]);
                
            // Update the timestamp for user viewing messages
            $conversation->last_read_user_at = now();
            $conversation->save();
        }

        $messages = $conversation->messages()->with('user')->get();
        
        return view('chat.show', compact('conversation', 'messages'));
    }

    /**
     * Create a new conversation.
     */
    public function create()
    {
        if (Auth::user()->is_admin) {
            $users = User::where('is_admin', false)->get();
            return view('chat.create', compact('users'));
        }
        
        return view('chat.create');
    }

    /**
     * Store a new conversation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'title' => 'nullable|string|max:255',
            'user_id' => Auth::user()->is_admin ? 'required|exists:users,id' : 'nullable',
        ]);

        // If admin is creating the conversation, use the selected user
        // Otherwise, use the authenticated user
        $userId = Auth::user()->is_admin ? $request->user_id : Auth::id();
        $isAdmin = Auth::user()->is_admin;

        $conversation = Conversation::create([
            'user_id' => $userId,
            'title' => $request->title ?? 'New Conversation',
            'last_message_at' => now(),
        ]);

        // Create the first message
        ChatMessage::create([
            'conversation_id' => $conversation->id,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'is_admin' => $isAdmin,
        ]);
        
        // Mark as read for the sender
        if ($isAdmin) {
            $conversation->last_read_admin_at = now();
        } else {
            $conversation->last_read_user_at = now();
        }
        $conversation->save();

        // Send email notification
        $this->sendEmailNotification($conversation, $request->message, $isAdmin);

        return redirect()->route('chat.show', $conversation)
            ->with('success', 'Conversation started successfully');
    }

    /**
     * Store a new message for the conversation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function storeMessage(Request $request, Conversation $conversation)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = new ChatMessage([
            'message' => $request->message,
            'is_admin' => Auth::user()->is_admin,
            'user_id' => Auth::id(),
        ]);

        $conversation->messages()->save($message);
        $conversation->last_message_at = now();
        
        // Mark messages as read for the sender
        if (Auth::user()->is_admin) {
            $conversation->last_read_admin_at = now();
        } else {
            $conversation->last_read_user_at = now();
        }
        
        $conversation->save();

        // For AJAX requests, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully'
            ]);
        }

        return redirect()->route('chat.show', $conversation);
    }

    /**
     * Send email notification for new messages.
     */
    private function sendEmailNotification(Conversation $conversation, $message, $isAdmin)
    {
        try {
            // Get the recipient based on who sent the message
            if ($isAdmin) {
                // Admin sent the message, notify the user
                $recipient = User::find($conversation->user_id);
                $sender = Auth::user()->name . ' (Admin)';
            } else {
                // User sent the message, notify admin
                // Use the contact email from location settings or fallback to a default admin
                $location = Location::first();
                $adminEmail = $location ? $location->contact_email : null;
                
                if (!$adminEmail) {
                    // Fallback to the first admin user
                    $admin = User::where('is_admin', true)->first();
                    if ($admin) {
                        $adminEmail = $admin->email;
                    }
                }
                
                $recipient = new \stdClass();
                $recipient->email = $adminEmail;
                $recipient->name = 'Admin';
                $sender = Auth::user()->name;
            }

            // Only send if we have a recipient
            if ($recipient && isset($recipient->email)) {
                Mail::to($recipient->email)->send(
                    new NewMessageNotification($sender, $message, $conversation)
                );
            }
        } catch (\Exception $e) {
            // Log error but don't stop the process
            \Log::error('Failed to send message notification: ' . $e->getMessage());
        }
    }

    /**
     * Get unread message count for the authenticated user
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        $unreadCount = 0;
        
        if ($user->is_admin) {
            // For admin, count conversations with unread messages from users
            $unreadCount = Conversation::where(function($query) {
                $query->whereNull('last_read_admin_at')
                      ->whereHas('messages', function($q) {
                          $q->where('is_admin', false);
                      });
            })->orWhere(function($query) {
                $query->whereNotNull('last_read_admin_at')
                      ->whereHas('messages', function($q) {
                          $q->where('is_admin', false)
                            ->where('created_at', '>', DB::raw('conversations.last_read_admin_at'));
                      });
            })->count();
        } else {
            // For regular users, count conversations with unread messages from admin
            $unreadCount = Conversation::where('user_id', $user->id)
                ->where(function($query) {
                    $query->whereNull('last_read_user_at')
                          ->whereHas('messages', function($q) {
                              $q->where('is_admin', true);
                          });
                })->orWhere(function($query) {
                    $query->whereNotNull('last_read_user_at')
                          ->whereHas('messages', function($q) {
                              $q->where('is_admin', true)
                                ->where('created_at', '>', DB::raw('conversations.last_read_user_at'));
                          });
                })->count();
        }
        
        return response()->json(['count' => $unreadCount]);
    }

    /**
     * Poll for new conversations.
     *
     * @return \Illuminate\Http\Response
     */
    public function pollConversations()
    {
        $user = Auth::user();
        
        if ($user->is_admin) {
            $conversations = Conversation::with(['user', 'latestMessage'])
                ->orderBy('last_message_at', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $conversations = Conversation::with(['latestMessage'])
                ->where('user_id', $user->id)
                ->orderBy('last_message_at', 'desc')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        $html = view('chat.partials.conversation-list', compact('conversations'))->render();
        return response()->json(['html' => $html]);
    }

    /**
     * Poll for new messages in a conversation.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\Http\Response
     */
    public function pollMessages(Conversation $conversation)
    {
        $this->authorize('view', $conversation);
        
        $messages = $conversation->messages()->orderBy('created_at')->get();
        
        // Mark messages as read for the current user
        if (Auth::user()->is_admin) {
            $conversation->last_read_admin_at = now();
            $conversation->save();
        } else {
            $conversation->last_read_user_at = now();
            $conversation->save();
        }
        
        $html = view('chat.partials.message-list', compact('conversation', 'messages'))->render();
        return response()->json(['html' => $html]);
    }

    /**
     * Mark messages as read via AJAX
     */
    public function markRead(Conversation $conversation)
    {
        // Check if the user is authorized to view this conversation
        if (Auth::user()->id !== $conversation->user_id && !Auth::user()->is_admin) {
            abort(403, 'Unauthorized action.');
        }

        // Mark messages as read based on who is viewing
        if (Auth::user()->is_admin) {
            $conversation->messages()
                ->where('is_admin', false)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } else {
            $conversation->messages()
                ->where('is_admin', true)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }
        
        return response()->json(['success' => true]);
    }
} 