<?php

namespace App\Filament\Resources\Residents\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\Unit;

class ResidentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('unit_id')
                    ->label('Unit')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->options(fn () =>
                        Unit::query()
                            ->limit(20)
                            ->get()
                            ->mapWithKeys(fn ($unit) => [
                                $unit->id => $unit->display_name,
                            ])
                    )
                    ->getSearchResultsUsing(function (string $search) {
                        return Unit::query()
                            ->whereRaw(
                                "CONCAT(block, '-', floor, '-', unit_no) LIKE ?",
                                ["%{$search}%"]
                            )
                            ->limit(20)
                            ->get()
                            ->mapWithKeys(fn ($unit) => [
                                $unit->id => $unit->display_name,
                            ]);
                    })
                    ->getOptionLabelUsing(function ($value): ?string {
                        return Unit::find($value)?->display_name;
                    }),

                TextInput::make('name')
                    ->required(),

                TextInput::make('ic_no')
                    ->label('IC / Passport No'),

                TextInput::make('phone')
                    ->tel(),

                TextInput::make('email')
                    ->email()
                    ->label('Email address'),

                Select::make('type')
                    ->options([
                        'owner' => 'Owner',
                        'tenant' => 'Tenant',
                    ])
                    ->default('owner')
                    ->required(),

                TextInput::make('status')
                    ->default('active')
                    ->required(),
            ]);
    }
}
