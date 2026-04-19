<?php

namespace App\Filament\Resources\RotationCycleItems\Pages;

use App\Filament\Resources\RotationCycleItems\RotationCycleItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRotationCycleItem extends EditRecord
{
    protected static string $resource = RotationCycleItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
