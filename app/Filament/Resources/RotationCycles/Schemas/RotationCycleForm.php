<?php

namespace App\Filament\Resources\RotationCycles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RotationCycleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre'),
                DateTimePicker:: make('created_at')
                    ->label('Generado el')
                    ->hint('DD/MM/AAAA')
                    ->native(false)
                    ->displayFormat('d / m / Y — h:i A')
                    ->seconds(false),
                Toggle::make('is_active')
                    ->label(fn ($state) => $state ? 'Activado' : 'Desactivado')
                    ->required(),
            ]);
    }
}
