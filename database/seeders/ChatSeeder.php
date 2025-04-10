<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Conversation;
use App\Models\ChatMessage;
use Carbon\Carbon;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds to create sample chat data.
     */
    public function run(): void
    {
        // Get or create a regular user
        $user = User::where('is_admin', false)->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
                'is_admin' => false,
            ]);
        }

        // Get or create an admin user
        $admin = User::where('is_admin', true)->first();
        if (!$admin) {
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'is_admin' => true,
            ]);
        }

        // Create multiple conversations
        for ($i = 1; $i <= 5; $i++) {
            $conversation = Conversation::create([
                'user_id' => $user->id,
                'title' => "Conversation {$i}",
                'last_message_at' => Carbon::now()->subMinutes(rand(1, 60)),
            ]);

            // Add messages to the conversation
            $messageCount = rand(3, 10); // Random number of messages
            for ($j = 1; $j <= $messageCount; $j++) {
                $isAdmin = $j % 2 == 0; // Alternate between user and admin messages
                $createdAt = Carbon::now()->subMinutes($messageCount - $j + rand(1, 5));

                ChatMessage::create([
                    'conversation_id' => $conversation->id,
                    'user_id' => $isAdmin ? $admin->id : $user->id,
                    'message' => $this->getRandomMessage($isAdmin, $j),
                    'is_admin' => $isAdmin,
                    'is_read' => true,
                    'created_at' => $createdAt,
                    'updated_at' => $createdAt,
                ]);

                // Update last message timestamp on conversation
                if ($j == $messageCount) {
                    $conversation->last_message_at = $createdAt;
                    $conversation->save();
                }
            }
        }

        $this->command->info('Sample chat conversations created successfully!');
    }

    /**
     * Get a random message based on sender and position.
     */
    private function getRandomMessage(bool $isAdmin, int $position): string
    {
        $adminMessages = [
            'Hello! How can I help you today?',
            'That\'s a great question. Let me check that for you.',
            'Thank you for reaching out to us.',
            'I\'ve reviewed your account and everything looks good.',
            'Could you please provide more details?',
            'We appreciate your patience.',
            'I\'ll make sure this gets taken care of right away.',
            'Is there anything else you need help with?',
            'I\'ve updated your information in our system.',
            'Your request has been submitted successfully.',
        ];

        $userMessages = [
            'Hi there, I have a question about my account.',
            'Thanks for your quick response!',
            'I\'m having trouble with one of the features.',
            'Could you explain how this works?',
            'That solved my problem, thank you!',
            'I need assistance with a payment issue.',
            'When will the new update be available?',
            'Is there a way to change my settings?',
            'I appreciate your help with this matter.',
            'Do you have any documentation I can refer to?',
        ];

        if ($position === 1 && !$isAdmin) {
            return $userMessages[0]; // First message is always the initial question
        }

        $messages = $isAdmin ? $adminMessages : $userMessages;
        return $messages[array_rand($messages)];
    }
} 