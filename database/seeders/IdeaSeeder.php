<?php

namespace Database\Seeders;

use App\Models\Hook;
use App\Models\Idea;
use Illuminate\Database\Seeder;

class IdeaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ideas = config('ideas');

        $hooks = Hook::query()
            ->orderBy('id')
            ->get();
        
        if ($hooks->count() !== count($ideas)) {
            throw new \Exception(
                "Mismatch: tienes {$hooks->count()} hooks y " . count($ideas) . " ideas."
            );
        }

        foreach ($ideas as $index => $ideaData) {
            $hook = $hooks[$index];

            Idea::updateOrCreate(
                [
                    'hook_id' => $hook->id,
                ],
                [
                    'title' => strtolower($ideaData['title']),
                    'description' => $ideaData['description'] ?? null
                ]
            );
        }
    }
}
