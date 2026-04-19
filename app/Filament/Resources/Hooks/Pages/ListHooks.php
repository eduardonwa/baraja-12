<?php

namespace App\Filament\Resources\Hooks\Pages;

use App\Filament\Resources\Hooks\HookResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHooks extends ListRecords
{
    protected static string $resource = HookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
        ];
    }
}
