<?php

namespace App\Filament\Widgets;

use App\Models\ContentMetric;
use Filament\Widgets\ChartWidget;

class VolumeOverviewChart extends ChartWidget
{
    protected ?string $heading = null;

    protected ?string $description = 'Mostrando 7 días de actividad';

    protected int | string | array $columnSpan = 'full';

    protected ?string $maxHeight = '250px';

    protected function getData(): array
    {
        $posts = ContentMetric::query()
            ->latest()
            ->take(14)
            ->get()
            ->reverse()
            ->values();

        return [
            'datasets' => [
                [
                    'label' => 'Views (7d)',
                    'data' => $posts->pluck('views_7d')->map(fn ($value) => (int) $value)->toArray(),
                    'borderWidth' => 2,
                    'pointRadius' => 3,
                    'pointHoverRadius' => 6,
                    'tension' => 0.35,
                    'fill' => false,
                ],
            ],
            'labels' => $posts->map(
                fn ($post, $i) => $post->created_at?->format('M d') ?? 'Point ' . ($i + 1)
            )->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
                'y' => [
                    'grid' => [
                        'display' => false,
                    ],
                ],
            ],
        ];
    }
}