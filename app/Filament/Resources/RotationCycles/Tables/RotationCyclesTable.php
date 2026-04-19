<?php

namespace App\Filament\Resources\RotationCycles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RotationCyclesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->date('j M Y')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Activo')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('gray'),
                TextColumn::make('status')
                    ->label('Estado')
                    ->getStateUsing(function ($record) {
                        if ($record->items_count === 0) {
                            return 'vacío';
                        }

                        if ($record->is_finished) {
                            return $record->is_active
                                ? 'terminado (activo)'
                                : 'terminado';
                        }

                        return $record->is_active
                            ? 'en progreso (activo)'
                            : 'en progreso';
                    })
                    ->badge()
                    ->color(function (string $state): string {
                        return match ($state) {
                            'vacío' => 'gray',
                            'en progreso' => 'warning',
                            'en progreso (activo)' => 'primary',
                            'terminado' => 'success',
                            'terminado (activo)' => 'info',
                            default => 'gray',
                        };
                    }),
                TextColumn::make('generation_mode')
                    ->label('Modo')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'azar' => 'info',
                        'manual' => 'gray',
                        default => 'gray',
                    }),
                TextColumn::make('items_count')
                    ->label('Combos')
                    ->counts('items')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Fecha actualización')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Editar'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
