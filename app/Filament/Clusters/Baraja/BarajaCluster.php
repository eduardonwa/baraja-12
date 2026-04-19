<?php

namespace App\Filament\Clusters\Baraja;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class BarajaCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::QueueList;

    protected static ?int $navigationSort = 2;
}
