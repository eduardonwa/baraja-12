<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class PerformanceHeader extends Widget
{
    protected string $view = 'filament.widgets.performance-header';

    protected int | string | array $columnSpan = 'full';
}
