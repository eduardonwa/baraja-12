<?php

namespace App\Filament\Clusters\Analiticas;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class AnaliticasCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChartBar;

    protected static ?int $navigationSort = 3;

    protected static ?string $label = 'Analíticas';
}
