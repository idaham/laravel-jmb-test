<?php

namespace App\Filament\Resources\Invoices\Tables;

use App\Filament\Resources\Invoices\InvoiceResource;
use App\Models\Invoice;
use Filament\Tables;
use Filament\Tables\Table;

class InvoicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_no')
                    ->label('Invoice No')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('unit.display_name')
                    ->label('Unit')
                    ->sortable(),

                Tables\Columns\TextColumn::make('billing_period')
                    ->label('Period')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('MYR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->colors([
                        'secondary' => 'draft',
                        'warning'   => 'issued',
                        'info'      => 'partial',
                        'success'   => 'paid',
                        'danger'    => 'overdue',
                    ]),
            ])
            // ✅ Filament v4 schema-table way to open a record
            ->recordUrl(fn (Invoice $record) =>
                InvoiceResource::getUrl('view', ['record' => $record])
            )
            ->defaultSort('issue_date', 'desc');
    }
}
