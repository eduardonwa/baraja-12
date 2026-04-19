<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\ContentHeader;
use App\Filament\Widgets\ContentOverview;
use App\Filament\Widgets\FunnelBreakdownWidget;
use App\Filament\Widgets\FunnelHeader;
use App\Filament\Widgets\FunnelKpiWidget;
use App\Filament\Widgets\PerformanceHeader;
use App\Filament\Widgets\PerformanceOverview;
use App\Filament\Widgets\PerformanceSummary;
use App\Filament\Widgets\VolumeHeader;
use App\Filament\Widgets\VolumeOverview;
use App\Filament\Widgets\VolumeOverviewChart;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected string $view = 'filament.pages.dashboard';

    public function getHeaderWidgetsColumns(): int | array
    {
        return 12;
    }

    protected function getHeaderWidgets(): array
    {
        return [
            FunnelHeader::class,
            FunnelBreakdownWidget::class,
            FunnelKpiWidget::class,

            VolumeHeader::class,
            VolumeOverviewChart::class,
            VolumeOverview::class,

            PerformanceHeader::class,
            PerformanceSummary::class,
            PerformanceOverview::class,
            
            ContentHeader::class,
            ContentOverview::class
        ];
    }
}
