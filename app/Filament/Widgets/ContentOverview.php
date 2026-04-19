<?php

namespace App\Filament\Widgets;

use App\Models\ContentMetric;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContentOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 4;

    protected function getStats(): array
    {
        $metrics = ContentMetric::query()
            ->withEngagementData()
            ->get();

        $avgLikesRate = round($metrics->avg('likes_engagement_rate') ?? 0, 2);
        $avgSavesRate = round($metrics->avg('saves_engagement_rate') ?? 0, 2);
        $avgCommentsRate = round($metrics->avg('comments_engagement_rate') ?? 0, 2);

        return [
            Stat::make('Atracción', number_format($avgLikesRate) . '%')
                ->description('Contenido atractivo')
                ->icon('heroicon-m-hand-thumb-up')
                ->color('success'),

            Stat::make('Utilidad', number_format($avgSavesRate) . '%')
                ->description('Contenido útil')
                ->icon('heroicon-m-bookmark')
                ->color('warning'),

            Stat::make('Conversación', number_format($avgCommentsRate) . '%')
                ->description('Genera conversación')
                ->icon('heroicon-m-chat-bubble-left-right')
                ->color('primary'),
        ];
    }
}
