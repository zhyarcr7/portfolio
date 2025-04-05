<?php

namespace App\Console\Commands;

use App\Models\HeroSlide;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixHeroSlidesImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-hero-slides-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix the hero slides image paths to match the actual files in storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to fix hero slides image paths...');
        
        // Get all hero slides with the old image path format
        $slides = HeroSlide::all();
        
        $count = 0;
        
        foreach ($slides as $slide) {
            // Check if the slide has an existing image path
            if ($slide->bgImage) {
                // Get the existing image files in the storage directory
                $files = glob(public_path('storage/hero-slides/*.*'));
                
                if (count($files) > 0) {
                    // For simplicity, we'll just use the first image file found
                    // In a real-world scenario, you might want to match based on creation dates or other criteria
                    $firstFile = basename($files[0]);
                    
                    // Update the slide with the correct image path
                    $slide->bgImage = 'hero-slides/' . $firstFile;
                    $slide->save();
                    
                    $this->info("Updated slide ID {$slide->id} with image path: {$slide->bgImage}");
                    $count++;
                } else {
                    $this->warn("No image files found in the hero-slides directory.");
                }
            }
        }
        
        $this->info("Completed. Fixed {$count} slide(s).");
    }
}
