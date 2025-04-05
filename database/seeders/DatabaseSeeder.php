<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call all seeders in the appropriate order
        $this->call([
            UserSeeder::class,
            NavigationSeeder::class,
            HeroSlideSeeder::class,
            ZhyarCVSeeder::class,
        ]);
    }
} 