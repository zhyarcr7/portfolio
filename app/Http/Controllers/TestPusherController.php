<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Pusher\Pusher;

class TestPusherController extends Controller
{
    public function test()
    {
        try {
            $options = [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
                'curl_options' => [
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0
                ]
            ];
            
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
            
            // Let's test triggering an event to see if it works
            $data = ['message' => 'Hello World'];
            $result = $pusher->trigger('test-channel', 'test-event', $data);
            
            return "Pusher class loaded successfully and event triggered! Result: " . json_encode($result);
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
} 