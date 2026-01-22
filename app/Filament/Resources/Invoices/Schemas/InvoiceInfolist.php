<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Text;
use Filament\Infolists\Components\RepeatableEntry;

class InvoiceInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // ===============================
                // Invoice Header
                // ===============================
                Section::make('Invoice Details')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('invoice_no')
                            ->label('Invoice No'),

                        TextEntry::make('unit.display_name')
                            ->label('Unit'),

                        TextEntry::make('billing_period')
                            ->label('Billing Period'),

                        TextEntry::make('issue_date')
                            ->label('Issue Date')
                            ->date(),

                        TextEntry::make('due_date')
                            ->label('Due Date')
                            ->date(),

                        TextEntry::make('status')
                            ->label('Status')
                            ->badge(),

                        TextEntry::make('total_amount')
                            ->label('Total Amount')
                            ->money('MYR'),

                        TextEntry::make('paid_amount')
                            ->label('Paid Amount')
                            ->money('MYR'),

                        TextEntry::make('balance_amount')
                            ->label('Outstanding')
                            ->money('MYR')
                            ->color(fn ($state) => $state > 0 ? 'danger' : 'success'),

                    ]),

                // ===============================
                // Invoice Items
                // ===============================
                Section::make('Invoice Items')
                    ->schema([
                        RepeatableEntry::make('items')
                            ->hiddenLabel()
                            ->schema([
                                TextEntry::make('description')
                                    ->extraAttributes(['class' => 'py-1 font-medium'])
                                    ->hiddenLabel(),

                                TextEntry::make('amount')
                                    ->hiddenLabel()
                                    ->money('MYR')
                                    ->extraAttributes(['class' => 'py-1'])
                                    ->alignEnd(),
                            ])
                            ->columns(2)
                            ->contained(false),
                    ]),


            ]);
    }
}
