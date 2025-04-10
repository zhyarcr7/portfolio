<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Work;
use App\Models\HeroSlide;
use App\Models\Navigation;
use App\Models\Testimonial;
use App\Models\ComingSoon;
use App\Models\ZhyarCV;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\ContactInformation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for dashboard
        $counts = [
            'blogs' => Blog::count(),
            'works' => Work::count(),
            'slides' => HeroSlide::count(),
            'navigation' => Navigation::count(),
            'testimonials' => Testimonial::count(),
            'comingSoon' => ComingSoon::count(),
            'unreadMessages' => Message::where('read', false)->count(), // For contact form messages
            'unreadConversations' => Conversation::whereHas('messages', function ($query) {
                $query->where('is_admin', false)->where('is_read', false);
            })->count(), // For chat messages
        ];
        
        try {
            $counts['zhyarCv'] = ZhyarCV::count();
        } catch (\Exception $e) {
            $counts['zhyarCv'] = 0;
        }
        
        // Add contact information data
        try {
            $contactInfo = ContactInformation::first();
            $counts['contactInfo'] = $contactInfo ? 1 : 0;
            $contactActive = $contactInfo && $contactInfo->is_active ? true : false;
        } catch (\Exception $e) {
            $counts['contactInfo'] = 0;
            $contactActive = false;
        }

        // Get recent conversations for admin
        $recentConversations = Conversation::with(['user', 'latestMessage'])
            ->orderBy('last_message_at', 'desc')
            ->take(5) // Limit to 5 recent conversations
            ->get();

        return view('admin.dashboard', compact('counts', 'recentConversations', 'contactActive'));
    }
} 