<?php

namespace App\Filament\Resources\RotationCycles\Pages;

use App\Filament\Resources\RotationCycles\RotationCycleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRotationCycle extends EditRecord
{
    protected static string $resource = RotationCycleResource::class;

    public function getTitle(): string
    {
        return 'Editar set';
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Eliminar'),
        ];
    }
}
