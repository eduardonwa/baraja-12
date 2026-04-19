<?php

namespace App\Filament\Widgets;

use App\Models\ContentMetric;
use Filament\Widgets\Widget;

class VolumeOverview extends Widget
{
    protected string $view = 'filament.widgets.volume-overview';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 3;

    public function getViewData(): array
    {
        $posts = ContentMetric::query()
            ->latest()
            ->take(14)
            ->get();

        $avgViews = round($posts->avg('views_7d') ?? 0);
        $avgProfileVisits = round($posts->avg('profile_visits_7d') ?? 0);
        $totalPosts = $posts->count();

        return [
            'avgViews' => number_format($avgViews),
            'avgProfileVisits' => number_format($avgProfileVisits),
            'totalPosts' => number_format($totalPosts),
        ];
    }
}