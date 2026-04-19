<?php

namespace App\Filament\Resources\RotationCycles\Pages;

use App\Filament\Resources\RotationCycles\RotationCycleResource;
use App\Models\Hook;
use App\Models\RotationCycle;
use App\Services\CycleNameGenerator;
use Filament\Actions\Action;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;

class ListRotationCycles extends ListRecords
{
    protected static string $resource = RotationCycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generateFullCycle')
                ->label('Barajar')
                ->icon('heroicon-o-sparkles')
                ->color('primary')
                ->modalHeading('Crear lote')
                ->modalSubmitActionLabel('Comenzar')
                ->schema([
                    TextInput::make('name')
                        ->label('Nombre del ciclo')
                        ->default(fn () => CycleNameGenerator::generateUnique())
                        ->required()
                        ->maxLength(255),
                ])
                ->action(function () {
                    DB::transaction(function () {
                        RotationCycle::query()->update([
                            'is_active' => false,
                        ]);

                        $hooks = Hook::query()
                            ->inRandomOrder()
                            ->get();

                        $cycle = RotationCycle::create([
                            'name' => CycleNameGenerator::generateUnique(),
                            'generation_mode' => 'azar',
                            'size' => $hooks->count(),
                            'is_active' => true,
                        ]);

                        foreach ($hooks as $index => $hook) {
                            $cycle->items()->create([
                                'hook_id' => $hook->id,
                                'position' => $index + 1,
                                'done' => false,
                                'idea_id' => null,
                            ]);
                        }
                    });
                }),

            Action::make('generateCustomCycle')
                ->label('Crear lote')
                ->icon('heroicon-o-rectangle-stack')
                ->color('gray')
                ->modalHeading('Crear lote')
                ->modalSubmitActionLabel('Comenzar')
                ->schema([
                    TextInput::make('name')
                        ->label('Nombre')
                        ->default(fn () => CycleNameGenerator::generateUnique())
                        ->required()
                        ->maxLength(255),

                    Radio::make('start_mode')
                        ->label('¿Cómo quieres comenzar?')
                        ->options([
                            'empty' => 'En blanco',
                            'selected_hooks' => 'Sé lo que estoy haciendo'
                        ])
                        ->default('empty')
                        ->required()
                        ->live(),
                    
                    Select::make('hook_ids')
                        ->label('Hooks')
                        ->multiple()
                        ->searchable()
                        ->preload()
                        ->options(fn () => Hook::query()->pluck('name', 'id')->toArray())
                        ->visible(fn ($get) => $get('start_mode') === 'selected_hooks')
                ])
                ->action(function (array $data) {
                    $cycle = DB::transaction(function () use ($data) {
                        RotationCycle::query()->update([
                            'is_active' => false
                        ]);

                        $selectedHookIds = $data['hook_ids'] ?? [];

                        $cycle = RotationCycle::create([
                            'name' => $data['name'],
                            'generation_mode' => 'manual',
                            'size' => $data['start_mode'] === 'selected_hooks'
                                ? count($selectedHookIds)
                                : 0,
                            'is_active' => true
                        ]);

                        if ($data['start_mode'] === 'selected_hooks' && count($selectedHookIds)) {
                            $hooks = Hook::query()
                                ->whereIn('id', $selectedHookIds)
                                ->get()
                                ->sortBy(fn ($hook) => array_search($hook->id, $selectedHookIds))
                                ->values();

                            foreach ($hooks as $index => $hook) {
                                $cycle->items()->create([
                                    'hook_id' => $hook->id,
                                    'position' => $index + 1,
                                    'done' => false,
                                    'idea_id' => null
                                ]);
                            }
                        }

                        return $cycle;
                    });

                    return redirect(RotationCycleResource::getUrl('edit', [
                        'record' => $cycle,
                    ]));
                })
        ];
    }
}
