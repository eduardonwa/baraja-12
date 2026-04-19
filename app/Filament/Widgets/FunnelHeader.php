<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class FunnelHeader extends Widget
{
    protected string $view = 'filament.widgets.funnel-header';

    protected int | string | array $columnSpan = 'full';
}
