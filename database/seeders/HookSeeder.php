<?php

namespace Database\Seeders;

use App\Models\Hook;
use Illuminate\Database\Seeder;

class HookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hooks = collect(config('hooks'))->map(function ($hook) {
            return array_merge($hook, [
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        })->toArray();

        Hook::upsert(
            $hooks,
            ['name'],
            ['description']
        );
    }
}
