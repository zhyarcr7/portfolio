<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin-user {email?} {name?} {password?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user for testing the application';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $email = $this->argument('email') ?? $this->ask('What is the admin email?', 'admin@example.com');
        $name = $this->argument('name') ?? $this->ask('What is the admin name?', 'Admin User');
        $password = $this->argument('password') ?? $this->secret('What is the admin password?') ?? 'password';

        // Check if user already exists
        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {
            // Ask if user should be updated to admin
            if (!$existingUser->is_admin) {
                if ($this->confirm("User {$email} already exists but is not an admin. Do you want to make them an admin?")) {
                    $existingUser->is_admin = true;
                    $existingUser->save();
                    $this->info("User {$email} has been updated to admin.");
                    return 0;
                }
            } else {
                $this->error("User {$email} already exists and is already an admin.");
                return 1;
            }
            
            $this->error("User {$email} already exists. No changes were made.");
            return 1;
        }

        // Create new admin user
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'is_admin' => true,
        ]);

        $this->info("Admin user {$email} created successfully!");
        return 0;
    }
}
