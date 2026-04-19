<?php

namespace App\Filament\Resources\Hooks\Pages;

use App\Filament\Resources\Hooks\HookResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHook extends EditRecord
{
    protected static string $resource = HookResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
