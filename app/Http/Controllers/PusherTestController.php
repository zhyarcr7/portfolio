<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class PusherTestController extends Controller
{
    /**
     * Display a test page for Pusher
     */
    public function index()
    {
        return view('pusher-test');
    }

    /**
     * Send a test message through Pusher
     */
    public function sendMessage(Request $request)
    {
        $message = $request->input('message', 'Test message: ' . time());
        
        // Trigger an event on the channel
        event(new \App\Events\PusherTestEvent($message));
        
        return response()->json(['success' => true, 'message' => $message]);
    }
} 