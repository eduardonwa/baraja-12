<?php

namespace App\Filament\Resources\Hooks;

use App\Filament\Clusters\Planeador\PlaneadorCluster;
use App\Filament\Resources\Hooks\Pages\CreateHook;
use App\Filament\Resources\Hooks\Pages\EditHook;
use App\Filament\Resources\Hooks\Pages\ListHooks;
use App\Filament\Resources\Hooks\Schemas\HookForm;
use App\Filament\Resources\Hooks\Tables\HooksTable;
use App\Models\Hook;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HookResource extends Resource
{
    protected static ?string $model = Hook::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $cluster = PlaneadorCluster::class;

    public static function form(Schema $schema): Schema
    {
        return HookForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HooksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListHooks::route('/'),
        ];
    }
}
