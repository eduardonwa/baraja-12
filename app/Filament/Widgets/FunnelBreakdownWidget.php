<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ContentMetrics\ContentMetricResource;
use App\Models\ContentMetric;
use Filament\Support\Assets\Css;
use Filament\Widgets\Widget;

class FunnelBreakdownWidget extends Widget
{
    protected string $view = 'filament.widgets.funnel-breakdown-widget';

    protected int | string | array $columnSpan = 8;

    protected static ?int $sort = 1;

    public function getViewData(): array
    {
        $metrics = ContentMetric::query()
            ->withConversionData()
            ->get();

        $avgViewToProfile = round(
            $metrics->avg(fn (ContentMetric $metric) => $metric->view_to_profile_conversion_rate) ?? 0,
            2
        );

        $avgProfileToFollow = round(
            $metrics->avg(fn (ContentMetric $metric) => $metric->profile_visit_to_follow_conversion_rate) ?? 0,
            2
        );
        
        $viewToProfileText = $this->getViewToProfileSupportText($avgViewToProfile);
        $profileToFollowText = $this->getProfileToFollowSupportText($avgProfileToFollow);

        $bestPost = $metrics
            ->sortByDesc(fn (ContentMetric $metric) => $this->calculateEfficiencyScore($metric))
            ->first();

        $topPost = $bestPost
            ? ($bestPost->title
                ?? $bestPost->rotationCycleItem?->title
                ?? "Post #{$bestPost->id}")
            : null;
                
        return [
            'subheading' => 'Dónde se rompe el recorrido entre vistas, perfil y seguidores (últimos 7 días).',

            'viewToProfileLabel' => 'Vistas → Perfil',
            'viewToProfileValue' => $this->formatPercentage($avgViewToProfile),
            'viewToProfileText' => $this->getViewToProfileSupportText($avgViewToProfile),
            'viewToProfileLead' => $viewToProfileText['lead'],
            'viewToProfileBody' => $viewToProfileText['body'],
            'viewToProfileState' => $viewToProfileText['state'],

            'profileToFollowLabel' => 'Perfil → Seguidores',
            'profileToFollowValue' => $this->formatPercentage($avgProfileToFollow),
            'profileToFollowText' => $this->getProfileToFollowSupportText($avgProfileToFollow),
            'profileToFollowLead' => $profileToFollowText['lead'],
            'profileToFollowBody' => $profileToFollowText['body'],
            'profileToFollowState' => $profileToFollowText['state'],

            'topPost' => $topPost,
            'topPostUrl' => $bestPost ? ContentMetricResource::getUrl('edit', ['record' => $bestPost]) : null
        ];
    }

    protected function formatPercentage(float $value, bool $precise = false): string
    {
        if ($precise || ($value > 0 && $value < 1)) {
            return number_format($value, 2) . '%';
        }

        return number_format($value) . '%';
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

    protected function getViewToProfileSupportText(float $score): array
    {
        if ($score >= 10) {
            return [
                'lead' => 'Buen gancho inicial',
                'body' => 'El contenido si empuja visitas al perfil',
                'state' => 'good'
            ];
        }

        if ($score >= 5) {
            return [
                'lead' => 'Interés medio',
                'body' => 'Parte de la audiencia entra al perfil, pero todavía hay fuga.',
                'state' => 'medium'
            ];
        }

        return [
            'lead' => 'Bajo interés',
            'body' => 'Pocas personas pasan de ver el contenido a visitar el perfil',
            'state' => 'bad'
        ];
    }

    protected function getProfileToFollowSupportText(float $score): array
    {
        if ($score >= 20) {
            return [
                'lead' => 'Buen cierre',
                'body' => 'Cuando entran al perfil, una parte importante termina siguiendo.',
                'state' => 'good'
            ];
        }

        if ($score >= 10) {
            return [
                'lead' => 'Conversión OK',
                'body' => 'Hay intención, pero falta rematar.',
                'state' => 'medium'
            ];
        }

        return [
            'lead' => 'Conversión baja',
            'body' => 'La gente entra al perfil',
            'state' => 'bad'
        ];
    }
}