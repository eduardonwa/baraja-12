<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class FAQs extends Page implements HasForms, HasInfolists
{
    protected string $view = 'filament.pages.f-a-qs';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedQuestionMarkCircle;

    protected static ?string $title = 'Guía';

    protected static ?string $navigationLabel = 'Guía';

    protected static ?int $navigationSort = 4;
}
