<?php

namespace Database\Seeders;

use App\Models\Hook;
use App\Models\Idea;
use App\Models\RotationCycle;
use App\Models\RotationCycleItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        $hooks = Hook::query()->orderBy('id')->get();

        if ($hooks->count() !== 34) {
            throw new \RuntimeException(
                "Se esperaban 34 hooks, pero hay {$hooks->count()}."
            );
        }

        $cycle = RotationCycle::create([
            'name' => 'DTC - 2 Weeks',
            'generation_mode' => 'azar',
            'size' => Hook::count(),
            'is_finished' => true,
            'is_active' => true,
        ]);

        $plan = $this->buildDashboardPlan();

        foreach ($plan as $index => $profile) {
            $hook = $hooks[$index];

            $idea = Idea::query()
                ->where('hook_id', $hook->id)
                ->first();

            if (! $idea) {
                throw new \RuntimeException(
                    "El hook {$hook->name} no tiene una idea asociada."
                );
            }

            $publishedAt = now()
                ->subDays(13 - intdiv($index, 2))
                ->setTime(rand(8, 21), rand(0, 59));

            $item = RotationCycleItem::create([
                'rotation_cycle_id' => $cycle->id,
                'hook_id' => $hook->id,
                'idea_id' => $idea?->id,
                'position' => $index + 1,
                'done' => true,
                'completed_at' => $publishedAt,
                'created_at' => $publishedAt,
                'updated_at' => $publishedAt,
            ]);

            // el metric ya se crea solo en RotationCycleItem::created()
            $metric = $item->metric;

            $metricData = $this->generateMetricData(
                type: $profile['type'],
                format: $profile['format'],
                quality: $profile['quality'],
            );

            $metric->update(array_merge($metricData, [
                'title' => $idea?->title ?? "Dashboard Test Content #" . ($index + 1),
                'type' => $profile['type'],
                'format' => $profile['format'],
                'hashtags_used' => '#marketing #branding #content',
                'people_tagged_and_dmd' => 'creator_a, creator_b',
                'created_at' => $publishedAt,
                'updated_at' => $publishedAt,
            ]));
        }
    }

    protected function buildDashboardPlan(): Collection
    {
        return collect([
            // TOP performers
            ['type' => 'reel',     'format' => 'meme',    'quality' => 'top'],
            ['type' => 'carousel', 'format' => 'updates', 'quality' => 'top'],
            ['type' => 'reel',     'format' => 'meme',    'quality' => 'top'],
            ['type' => 'carousel', 'format' => 'story',   'quality' => 'top'],
            ['type' => 'reel',     'format' => 'updates', 'quality' => 'top'],
            ['type' => 'image',    'format' => 'meme',    'quality' => 'top'],
            ['type' => 'carousel', 'format' => 'updates', 'quality' => 'top'],
            ['type' => 'image',    'format' => 'meme',    'quality' => 'top'],

            // STRONG
            ['type' => 'carousel', 'format' => 'updates', 'quality' => 'strong'],
            ['type' => 'reel',     'format' => 'story',   'quality' => 'strong'],
            ['type' => 'image',    'format' => 'updates', 'quality' => 'strong'],
            ['type' => 'reel',     'format' => 'meme',    'quality' => 'strong'],
            ['type' => 'carousel', 'format' => 'meme',    'quality' => 'strong'],
            ['type' => 'image',    'format' => 'story',   'quality' => 'strong'],
            ['type' => 'reel',     'format' => 'updates', 'quality' => 'strong'],
            ['type' => 'carousel', 'format' => 'updates', 'quality' => 'strong'],
            ['type' => 'reel',     'format' => 'meme',    'quality' => 'strong'],
            ['type' => 'image',    'format' => 'updates', 'quality' => 'strong'],

            // MEDIUM
            ['type' => 'image',    'format' => 'updates', 'quality' => 'medium'],
            ['type' => 'carousel', 'format' => 'story',   'quality' => 'medium'],
            ['type' => 'reel',     'format' => 'story',   'quality' => 'medium'],
            ['type' => 'image',    'format' => 'meme',    'quality' => 'medium'],
            ['type' => 'carousel', 'format' => 'meme',    'quality' => 'medium'],
            ['type' => 'reel',     'format' => 'updates', 'quality' => 'medium'],
            ['type' => 'image',    'format' => 'story',   'quality' => 'medium'],
            ['type' => 'carousel', 'format' => 'updates', 'quality' => 'medium'],
            ['type' => 'reel',     'format' => 'story',   'quality' => 'medium'],

            // WEAK
            ['type' => 'image',    'format' => 'story',   'quality' => 'weak'],
            ['type' => 'image',    'format' => 'updates', 'quality' => 'weak'],
            ['type' => 'carousel', 'format' => 'story',   'quality' => 'weak'],
            ['type' => 'reel',     'format' => 'story',   'quality' => 'weak'],
            ['type' => 'image',    'format' => 'story',   'quality' => 'weak'],
            ['type' => 'carousel', 'format' => 'updates', 'quality' => 'weak'],
            ['type' => 'reel',     'format' => 'story',   'quality' => 'weak'],
        ]);
    }

    protected function generateMetricData(string $type, string $format, string $quality): array
    {
        $views7d = $this->generateViews($type, $format, $quality);

        [$viewToProfileMin, $viewToProfileMax] = match ($quality) {
            'top'    => [10, 16],
            'strong' => [7, 11],
            'medium' => [4, 7],
            'weak'   => [1, 4],
        };

        [$profileToFollowMin, $profileToFollowMax] = match ($quality) {
            'top'    => [20, 30],
            'strong' => [14, 22],
            'medium' => [8, 14],
            'weak'   => [3, 8],
        };

        $viewToProfileRate = $this->randomPercent($viewToProfileMin, $viewToProfileMax);
        $profileToFollowRate = $this->randomPercent($profileToFollowMin, $profileToFollowMax);

        $profileVisits7d = max(1, (int) round($views7d * ($viewToProfileRate / 100)));
        $follows7d = max(0, (int) round($profileVisits7d * ($profileToFollowRate / 100)));

        $rates = $this->buildEngagementRates($type, $format, $quality);

        $likes7d = (int) round($views7d * ($rates['likes'] / 100));
        $comments7d = (int) round($views7d * ($rates['comments'] / 100));
        $shares7d = (int) round($views7d * ($rates['shares'] / 100));
        $saves7d = (int) round($views7d * ($rates['saves'] / 100));
        $reposts7d = (int) round($views7d * ($rates['reposts'] / 100));

        return [
            'views_24h' => (int) round($views7d * 0.42),
            'views_3d' => (int) round($views7d * 0.73),
            'views_7d' => $views7d,

            'likes_24h' => (int) round($likes7d * 0.45),
            'likes_3d' => (int) round($likes7d * 0.75),
            'likes_7d' => $likes7d,

            'comments_24h' => (int) round($comments7d * 0.45),
            'comments_3d' => (int) round($comments7d * 0.75),
            'comments_7d' => $comments7d,

            'shares_24h' => (int) round($shares7d * 0.45),
            'shares_3d' => (int) round($shares7d * 0.75),
            'shares_7d' => $shares7d,

            'saves_24h' => (int) round($saves7d * 0.45),
            'saves_3d' => (int) round($saves7d * 0.75),
            'saves_7d' => $saves7d,

            'reposts_24h' => (int) round($reposts7d * 0.45),
            'reposts_3d' => (int) round($reposts7d * 0.75),
            'reposts_7d' => $reposts7d,

            'profile_visits_24h' => (int) round($profileVisits7d * 0.45),
            'profile_visits_3d' => (int) round($profileVisits7d * 0.75),
            'profile_visits_7d' => $profileVisits7d,

            'follows_24h' => (int) round($follows7d * 0.45),
            'follows_3d' => (int) round($follows7d * 0.75),
            'follows_7d' => $follows7d,
        ];
    }

    protected function generateViews(string $type, string $format, string $quality): int
    {
        $baseViews = match ($type) {
            'reel'     => rand(90000, 220000),
            'carousel' => rand(35000, 95000),
            'image'    => rand(18000, 60000),
        };

        $formatMultiplier = match ($format) {
            'meme'    => 1.20,
            'updates' => 0.90,
            'story'   => 0.80,
        };

        $qualityMultiplier = match ($quality) {
            'top'    => 1.40,
            'strong' => 1.15,
            'medium' => 1.00,
            'weak'   => 0.75,
        };

        return (int) round($baseViews * $formatMultiplier * $qualityMultiplier);
    }

    protected function buildEngagementRates(string $type, string $format, string $quality): array
    {
        $likeRate = match ($format) {
            'meme'    => $this->randomPercent(7.0, 11.0),
            'updates' => $this->randomPercent(4.0, 7.0),
            'story'   => $this->randomPercent(3.5, 6.5),
        };

        $saveRate = match ($type) {
            'carousel' => $this->randomPercent(3.5, 7.0),
            'reel'     => $this->randomPercent(1.2, 3.0),
            'image'    => $this->randomPercent(1.0, 2.5),
        };

        $commentRate = match ($format) {
            'story'   => $this->randomPercent(1.5, 3.5),
            'updates' => $this->randomPercent(1.2, 2.8),
            'meme'    => $this->randomPercent(0.8, 1.8),
        };

        $shareRate = match ($format) {
            'meme'    => $this->randomPercent(2.0, 5.0),
            'updates' => $this->randomPercent(0.8, 1.8),
            'story'   => $this->randomPercent(0.5, 1.2),
        };

        $repostRate = match ($type) {
            'reel'     => $this->randomPercent(0.2, 1.2),
            'carousel' => $this->randomPercent(0.1, 0.8),
            'image'    => $this->randomPercent(0.05, 0.5),
        };

        $qualityMultiplier = match ($quality) {
            'top'    => 1.30,
            'strong' => 1.10,
            'medium' => 0.95,
            'weak'   => 0.70,
        };

        return [
            'likes' => $likeRate * $qualityMultiplier,
            'comments' => $commentRate * $qualityMultiplier,
            'shares' => $shareRate * $qualityMultiplier,
            'saves' => $saveRate * $qualityMultiplier,
            'reposts' => $repostRate * $qualityMultiplier,
        ];
    }

    protected function randomPercent(float $min, float $max): float
    {
        return rand((int) ($min * 100), (int) ($max * 100)) / 100;
    }
}
