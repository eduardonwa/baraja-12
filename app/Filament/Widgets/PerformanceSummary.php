<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContentMetrics\ContentMetricResource;
use App\Models\ContentMetric;
use Filament\Widgets\Widget;

class PerformanceSummary extends Widget
{
    protected string $view = 'filament.widgets.performance-summary';

    protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        $posts = ContentMetric::query()->withEngagementData()->get();

        $posts = $posts->map(function ($post) {
            $post->total_engagement =
                (int) $post->likes_7d +
                (int) $post->comments_7d +
                (int) $post->shares_7d +
                (int) $post->saves_7d +
                (int) $post->reposts_7d;

            return $post;
        });

        $best = $posts->sortByDesc('total_engagement')->first();
        $worst = $posts->sortBy('total_engagement')->first();

        $bestPostUrl = $best
            ? ContentMetricResource::getUrl('edit', ['record' => $best])
            : null;

        $worstPostUrl = $worst
            ? ContentMetricResource::getUrl('edit', ['record' => $worst])
            : null;

        return [
            'best' => $best,
            'bestPostUrl' => $bestPostUrl,
            'worst' => $worst,
            'worstPostUrl' => $worstPostUrl,
        ];
    }
}