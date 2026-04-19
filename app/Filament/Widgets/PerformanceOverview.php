<?php

namespace App\Filament\Widgets;

use App\Models\ContentMetric;
use Filament\Widgets\ChartWidget;

class PerformanceOverview extends ChartWidget
{
    protected ?string $heading = null;

    protected ?string $description = 'Mostrando 28 resultados';

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '377px';

    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $posts = ContentMetric::query()
            ->latest()
            ->take(28)
            ->get()
            ->reverse()
            ->values();

        $labels = $posts->map(function ($post, $i) {
            return $post->title
                ?? 'item ' . ($post->rotationCycleItem?->position ?? $i + 1);
        })->toArray();

        $totalEngagement = $posts->map(function ($post) {
            return
                (int) $post->likes_7d +
                (int) $post->comments_7d +
                (int) $post->shares_7d +
                (int) $post->saves_7d +
                (int) $post->reposts_7d;
        })->toArray();

        $comments = $posts->pluck('comments_7d')->map(fn ($v) => (int) $v)->toArray();
        $saves = $posts->pluck('saves_7d')->map(fn ($v) => (int) $v)->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Interacción Total',
                    'data' => $totalEngagement,
                ],
                [
                    'label' => 'Comentarios',
                    'data' => $comments,
                ],
                [
                    'label' => 'Guardados',
                    'data' => $saves,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'ticks' => [
                        'display' => false
                    ],
                    'grid' => [
                        'display' => false
                    ]
                ]
            ]
        ];
    }
}
