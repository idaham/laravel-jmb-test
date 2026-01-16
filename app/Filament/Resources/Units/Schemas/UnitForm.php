<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rule;

class UnitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('block')
                    ->required()
                    ->maxLength(10)
                    ->afterStateUpdated(fn ($state, callable $set) =>
                        $set('block', strtoupper($state))
                    ),

                TextInput::make('floor')
                    ->required()
                    ->maxLength(10)
                    ->afterStateUpdated(fn ($state, callable $set) =>
                        $set('floor', strtoupper($state))
                    ),

                TextInput::make('unit_no')
                    ->helperText('Unique per Block and Floor')
                    ->required()
                    ->rule(function (callable $get) {
                        return Rule::unique('units', 'unit_no')
                            ->where('block', $get('block'))
                            ->where('floor', $get('floor'))
                            ->ignore(request()->route('record'));
                    }),

                Select::make('type')
                    ->options([
                        'residential' => 'Residential',
                        'shop'        => 'Shop',
                        'office'     => 'Office',
                    ])
                    ->nullable(),

                TextInput::make('size_sqft')
                    ->numeric()
                    ->label('Size (sqft)'),

                Select::make('status')
                    ->options([
                        'active'   => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }
}
