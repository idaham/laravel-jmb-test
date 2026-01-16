<?php

namespace App\Filament\Resources\Residents;

use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\Residents\Pages\CreateResident;
use App\Filament\Resources\Residents\Pages\EditResident;
use App\Filament\Resources\Residents\Pages\ListResidents;
use App\Filament\Resources\Residents\Pages\ViewResident;
use App\Filament\Resources\Residents\Schemas\ResidentForm;
use App\Filament\Resources\Residents\Schemas\ResidentInfolist;
use App\Filament\Resources\Residents\Tables\ResidentsTable;
use App\Models\Resident;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ResidentResource extends Resource
{
    protected static ?string $model = Resident::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ResidentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ResidentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ResidentsTable::configure($table);
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
            'index' => ListResidents::route('/'),
            'create' => CreateResident::route('/create'),
            'view' => ViewResident::route('/{record}'),
            'edit' => EditResident::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->can('access system') ?? false;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->can('manage residents') ?? false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->can('manage residents') ?? false;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->can('manage residents') ?? false;
    }

}
