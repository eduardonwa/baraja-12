<?php

namespace App\Filament\Widgets;

use App\Models\ContentMetric;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class FunnelKpiWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 4;

    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $metrics = ContentMetric::query()
            ->withConversionData()
            ->get();

        $avgEfficiency = round(
            $metrics->avg(fn (ContentMetric $metric) => $this->calculateEfficiencyScore($metric)) ?? 0,
            2
        );

        return [
            Stat::make('Tasa de conversión a seguidores', $this->formatPercentage($avgEfficiency, true))
                ->description($this->getEfficiencyInsight($avgEfficiency))
                ->icon('heroicon-m-bolt')
                ->color($this->getEfficiencyColor($avgEfficiency)),
        ];
    }

    protected function calculateEfficiencyScore(ContentMetric $metric): float
    {
        return round(
            ($metric->view_to_profile_conversion_rate / 100)
            * ($metric->profile_visit_to_follow_conversion_rate / 100)
            * 100,
            2
        );
    }

    protected function formatPercentage(float $value, bool $precise = false): string
    {
        if ($precise || ($value > 0 && $value < 1)) {
            return number_format($value, 2) . '%';
        }

        return number_format($value) . '%';
    }

    protected function getEfficiencyInsight(float $score): string
    {
        if ($score >= 3) {
            return 'Embudo fuerte: Convierte bien a seguidores';
        }

        if ($score >= 1) {
            return 'Conversión OK: Hay fricción entre contenido y perfil';
        }

        return 'Baja conversión: Muchas vistas, pocos seguidores';
    }

    protected function getEfficiencyColor(float $score): string
    {
        if ($score >= 3) {
            return 'success';
        }

        if ($score >= 1) {
            return 'warning';
        }

        return 'danger';
    }
}