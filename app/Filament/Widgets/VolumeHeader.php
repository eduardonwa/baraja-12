<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class VolumeHeader extends Widget
{
    protected string $view = 'filament.widgets.volume-header';

    protected int | string | array $columnSpan = 'full';
}
