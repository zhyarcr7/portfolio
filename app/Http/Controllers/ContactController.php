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
            // Log at the beginning
            Log::info('Contact form submission started');
            
            // Validate the form data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|string|max:255',
                'message' => 'required|string',
            ]);
            
            Log::info('Contact form data validated', ['name' => $validated['name'], 'email' => $validated['email']]);
            
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
            $message = Message::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'read' => false,
            ]);
            
            Log::info('Message saved to database', ['message_id' => $message->id]);
            
            // Send HTML email instead of raw text
            $recipient = 'your-actual-email@gmail.com'; // Replace with your actual email
            
            Log::info('Sending HTML email to ' . $recipient);
            
            // HTML email content
            $htmlContent = view('emails.contact-html', [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'date' => now()->format('F j, Y, g:i a')
            ])->render();
            
            Mail::html($htmlContent, function($message) use ($validated, $recipient) {
                $message->to($recipient);
                $message->subject('Website Contact: ' . $validated['subject']);
                $message->from(config('mail.from.address'), config('mail.from.name'));
            });
            
            Log::info('HTML email sent to ' . $recipient);
            
            // For AJAX requests, return JSON response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Thank you for your message! We will get back to you soon.',
                    'toast' => [
                        'type' => 'success',
                        'title' => 'Message Sent!',
                        'message' => 'Thank you for your message! We will get back to you soon.'
                    ]
                ]);
            }
            
            // For regular requests, redirect back with success message
            return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
            
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error submitting contact form: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            // For AJAX requests, return JSON response
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Sorry, there was a problem: ' . $e->getMessage(),
                    'errors' => $e instanceof \Illuminate\Validation\ValidationException ? $e->errors() : null,
                    'toast' => [
                        'type' => 'error',
                        'title' => 'Error!',
                        'message' => 'Sorry, there was a problem: ' . $e->getMessage()
                    ]
                ], 422);
            }
            
            // For regular requests, redirect back with error message
            return redirect()->back()->with('error', 'Sorry, there was a problem: ' . $e->getMessage());
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
                // Fallback to ContactInformation if available
                $contactInfo = \App\Models\ContactInformation::where('is_active', true)->first();
                if ($contactInfo && $contactInfo->email) {
                    $adminEmail = $contactInfo->email;
                } else {
                    // Final fallback to test account for debugging
                    $adminEmail = 'test@example.com';
                }
            }
            
            // Log email debugging info
            Log::info('Attempting to send email notification');
            Log::info('Admin email: ' . $adminEmail);
            
            // Dump detailed mail config for debugging
            $mailConfig = config('mail');
            Log::info('DETAILED MAIL CONFIG: ' . json_encode($mailConfig));
            
            // Force attempt a direct mail sending
            try {
                Log::info('Attempting to send with mailable class ContactFormSubmission');
                
                // First attempt with ContactFormSubmission
                Mail::to($adminEmail)->send(
                    new ContactFormSubmission($data)
                );
                
                Log::info('Email appeared to send successfully with mailable class');
            } catch (\Exception $e) {
                Log::error('Failed with mailable class: ' . $e->getMessage());
                Log::error('Exception type: ' . get_class($e));
                Log::error('Exception trace: ' . $e->getTraceAsString());
                
                try {
                    Log::info('Attempting fallback with Mail::raw');
                    // If that fails, try a raw mail as fallback
                    Mail::raw('Contact Form Submission from ' . $data['name'] . "\n\n" . 
                              'Email: ' . $data['email'] . "\n" .
                              'Subject: ' . $data['subject'] . "\n\n" . 
                              'Message: ' . $data['message'], function($message) use ($adminEmail, $data) {
                        $message->to($adminEmail);
                        $message->subject('New Contact Form: ' . $data['subject']);
                    });
                    
                    Log::info('Raw email appeared to send successfully');
                } catch (\Exception $innerException) {
                    Log::error('Even raw email failed: ' . $innerException->getMessage());
                    Log::error('Inner exception type: ' . get_class($innerException));
                    Log::error('Inner exception trace: ' . $innerException->getTraceAsString());
                    throw $innerException;
                }
            }
            
            Log::info('Email notification process completed for: ' . $adminEmail);
            
        } catch (\Exception $e) {
            // Log error but don't stop the process
            Log::error('Failed to send contact form email: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            throw $e; // Rethrow to be caught by the calling method
        }
    }
}
