<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // các seeder không có khóa ngoại
            CategorySeeder::class,
            BrandSeeder::class,
            UserSeeder::class,
        
            // các seeder có khóa ngoại
            ProductSeeder::class,
            PostSeeder::class
        ]);
    }
}
