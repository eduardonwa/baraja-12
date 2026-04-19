<?php

namespace App\Filament\Resources\ContentMetrics\Pages;

use App\Filament\Resources\ContentMetrics\ContentMetricResource;
use App\Filament\Resources\RotationCycles\RotationCycleResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditContentMetric extends EditRecord
{
    protected static string $resource = ContentMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('backToCycle')
                ->label('Regresar al set')
                ->icon('heroicon-o-arrow-uturn-left')
                ->url(fn () => RotationCycleResource::getUrl('edit', [
                    'record' => $this->record->rotationCycleItem->rotation_cycle_id,
                ])),
        ];
    }
}
