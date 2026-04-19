<?php

namespace App\Filament\Resources\ContentMetrics;

use App\Filament\Clusters\Analiticas\AnaliticasCluster;
use App\Filament\Resources\ContentMetrics\Pages\CreateContentMetric;
use App\Filament\Resources\ContentMetrics\Pages\EditContentMetric;
use App\Filament\Resources\ContentMetrics\Pages\ListContentMetrics;
use App\Filament\Resources\ContentMetrics\Schemas\ContentMetricForm;
use App\Filament\Resources\ContentMetrics\Schemas\ContentMetricInfolist;
use App\Filament\Resources\ContentMetrics\Tables\ContentMetricsTable;
use App\Models\ContentMetric;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ContentMetricResource extends Resource
{
    protected static ?string $model = ContentMetric::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;

    protected static ?string $label = 'Analítica';
    
    protected static ?string $pluralLabel = 'Analíticas';

    protected static ?string $cluster = AnaliticasCluster::class;

    public static function form(Schema $schema): Schema
    {
        return ContentMetricForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ContentMetricInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentMetricsTable::configure($table);
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
            'index' => ListContentMetrics::route('/'),
            'create' => CreateContentMetric::route('/create'),
            'edit' => EditContentMetric::route('/{record}/edit'),
        ];
    }
}
