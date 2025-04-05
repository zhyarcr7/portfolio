<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Conversation;
use App\Models\ChatMessage;
use App\Models\Location;
use App\Mail\ContactFormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        try {
            // Validate the form data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);
            
            // If user is logged in, create a conversation
            if (Auth::check()) {
                $conversation = Conversation::create([
                    'user_id' => Auth::id(),
                    'title' => $validated['subject'],
                    'last_message_at' => now(),
                ]);
                
                // Create the first message
                ChatMessage::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => Auth::id(),
                    'message' => $validated['message'],
                    'is_admin' => false,
                ]);
                
                // For AJAX requests, return JSON response
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Your message has been sent! We will respond to you shortly.',
                        'redirect' => route('chat.show', $conversation)
                    ]);
                }
                
                // For regular requests, redirect to the conversation
                return redirect()->route('chat.show', $conversation)
                    ->with('success', 'Your message has been sent! We will respond to you shortly.');
            }
            
            // Create a new message in the database
            Message::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'read' => false,
            ]);
            
            // Send email notification to admin
            $this->sendEmailNotification($validated);
            
            // For AJAX requests, return JSON response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your message! We will get back to you soon.'
                ]);
            }
            
            // For regular requests, redirect back with success message
            return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error submitting contact form: ' . $e->getMessage());
            
            // For AJAX requests, return JSON response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, there was a problem submitting your message. Please try again later.',
                    'errors' => $e instanceof \Illuminate\Validation\ValidationException ? $e->errors() : null
                ], 422);
            }
            
            // For regular requests, redirect back with error message
            return redirect()->back()->with('error', 'Sorry, there was a problem submitting your message. Please try again later.');
        }
    }
    
    /**
     * Send email notification for contact form submission
     */
    private function sendEmailNotification($data)
    {
        try {
            // Get admin email from location settings
            $location = Location::first();
            $adminEmail = $location ? $location->contact_email : null;
            
            if (!$adminEmail) {
                // Fallback to a default email
                $adminEmail = config('mail.from.address');
            }
            
            // Send the email
            Mail::to($adminEmail)->send(
                new ContactFormSubmission($data)
            );
        } catch (\Exception $e) {
            // Log error but don't stop the process
            Log::error('Failed to send contact form email: ' . $e->getMessage());
        }
    }
}
