<?php

namespace App\Filament\Resources\Units\RelationManagers;

use App\Filament\Resources\Residents\ResidentResource;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ResidentsRelationManager extends RelationManager
{
    protected static string $relationship = 'residents';

    protected static ?string $relatedResource = ResidentResource::class;

    protected static ?string $title = 'Residents';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge(),

                Tables\Columns\TextColumn::make('status')
                    ->badge(),
            ])
            ->actions([
            ])
            ->recordUrl(
                fn ($record) => ResidentResource::getUrl('view', ['record' => $record])
            );
    }
}
