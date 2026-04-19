<?php

namespace App\Filament\Clusters\Planeador;

use BackedEnum;
use Filament\Clusters\Cluster;
use Filament\Support\Icons\Heroicon;

class PlaneadorCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Clipboard;

    protected static ?int $navigationSort = 1;
}
