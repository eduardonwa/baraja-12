<?php

namespace App\Filament\Resources\ContentMetrics\Pages;

use App\Filament\Resources\ContentMetrics\ContentMetricResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewContentMetric extends ViewRecord
{
    protected static string $resource = ContentMetricResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Editar')
        ];
    }
}
