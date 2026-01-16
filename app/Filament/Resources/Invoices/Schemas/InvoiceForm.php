<?php

namespace App\Filament\Resources\Invoices\Schemas;

use App\Models\Unit;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('unit_id')
                    ->label('Unit')
                    ->searchable()
                    ->required()
                    ->options(fn () =>
                        Unit::query()
                            ->orderBy('block')
                            ->orderBy('floor')
                            ->orderBy('unit_no')
                            ->get()
                            ->mapWithKeys(fn ($unit) => [
                                $unit->id => $unit->display_name,
                            ])
                    ),

                TextInput::make('invoice_no')
                    ->label('Invoice No')
                    ->required()
                    ->unique(ignoreRecord: true),

                TextInput::make('billing_period')
                    ->label('Billing Period')
                    ->placeholder('YYYY-MM')
                    ->required(),

                DatePicker::make('issue_date')
                    ->label('Issue Date')
                    ->required(),

                DatePicker::make('due_date')
                    ->label('Due Date')
                    ->required(),

                // 🔽 Invoice Items
                Repeater::make('items')
                    ->label('Invoice Items')
                    ->relationship()
                    ->schema([
                        TextInput::make('description')
                            ->required()
                            ->columnSpan(2),

                        TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->prefix('RM'),
                    ])
                    ->defaultItems(1)
                    ->columns(3)
                    ->reorderable()
                    ->columnSpanFull(),
            ]);
    }
}
