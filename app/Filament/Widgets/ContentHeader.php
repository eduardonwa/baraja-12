<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ContentHeader extends Widget
{
    protected string $view = 'filament.widgets.content-header';

    protected int | string | array $columnSpan = 'full';
}
