<?php

namespace App\Filament\Resources\Units\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class UnitsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('block')
                    ->label('Block')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('floor')
                    ->label('Floor')
                    ->sortable(),

                TextColumn::make('unit_no')
                    ->label('Unit No')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('type')
                    ->badge()
                    ->sortable(),

                TextColumn::make('size_sqft')
                    ->label('Size (sqft)')
                    ->sortable(),

                TextColumn::make('residents_count')
                    ->label('Residents')
                    ->counts('residents')
                    ->sortable(),

                TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'success' => 'active',
                        'gray' => 'inactive',
                    ])
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn () => auth()->user()?->can('manage units')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->can('manage units')),
                    ForceDeleteBulkAction::make()
                        ->visible(fn () => auth()->user()?->can('manage units')),
                    RestoreBulkAction::make()
                        ->visible(fn () => auth()->user()?->can('manage units')),
                ]),
            ]);
    }
}
