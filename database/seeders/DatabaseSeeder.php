<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\DashboardSeeder;
use Database\Seeders\HookSeeder;
use Database\Seeders\IdeaSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'eduardo',
            'email' => 'eduardo@hotmail.com',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            HookSeeder::class,
            IdeaSeeder::class,
            DashboardSeeder::class
        ]);
    }
}
