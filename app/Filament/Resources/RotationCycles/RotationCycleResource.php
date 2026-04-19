<?php

namespace App\Filament\Resources\RotationCycles;

use App\Filament\Clusters\Baraja\BarajaCluster;
use App\Filament\Resources\RotationCycles\Pages\CreateRotationCycle;
use App\Filament\Resources\RotationCycles\Pages\EditRotationCycle;
use App\Filament\Resources\RotationCycles\Pages\ListRotationCycles;
use App\Filament\Resources\RotationCycles\RelationManagers\ItemsRelationManager;
use App\Filament\Resources\RotationCycles\Schemas\RotationCycleForm;
use App\Filament\Resources\RotationCycles\Tables\RotationCyclesTable;
use App\Models\RotationCycle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RotationCycleResource extends Resource
{
    protected static ?string $model = RotationCycle::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Set';
    
    protected static ?string $pluralModelLabel = 'Sets';

    protected static ?string $cluster = BarajaCluster::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return RotationCycleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RotationCyclesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRotationCycles::route('/'),
            'create' => CreateRotationCycle::route('/create'),
            'edit' => EditRotationCycle::route('/{record}/edit'),
        ];
    }
}
