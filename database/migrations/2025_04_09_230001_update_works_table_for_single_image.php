<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Work;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if the image column already exists
        if (!Schema::hasColumn('works', 'image')) {
            Schema::table('works', function (Blueprint $table) {
                $table->string('image')->nullable()->after('description');
            });
        }
        
        // Migrate data from the old column to the new one
        $works = Work::all();
        foreach ($works as $work) {
            if (!empty($work->images) && is_array($work->images) && count($work->images) > 0) {
                // Take the first image from the array
                $work->image = $work->images[0];
                $work->save();
            }
        }
        
        // Check if the images column exists before trying to drop it
        if (Schema::hasColumn('works', 'images')) {
            Schema::table('works', function (Blueprint $table) {
                $table->dropColumn('images');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the images column already exists
        if (!Schema::hasColumn('works', 'images')) {
            Schema::table('works', function (Blueprint $table) {
                $table->json('images')->nullable()->after('description');
            });
        }
        
        // Migrate data back from the new column to the old one
        $works = Work::all();
        foreach ($works as $work) {
            if (!empty($work->image)) {
                $work->images = [$work->image];
                $work->save();
            }
        }
        
        // No need to drop the image column in down() as it likely 
        // already existed before this migration
    }
};
