<?php

namespace App\Filament\Resources\Invoices\Tables;

use App\Filament\Resources\Invoices\InvoiceResource;
use App\Models\Invoice;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Actions\Action;
use Filament\Actions\ViewAction;

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

            // 👉 Row actions (THIS IS NEW)
            ->actions([
                ViewAction::make(),

                Action::make('pay')
                    ->label('Pay')
                    ->icon('heroicon-o-banknotes')
                    ->color('success')
                    ->visible(fn (Invoice $record) =>
                        $record->balance_amount > 0 &&
                        in_array($record->status, ['issued', 'partial'])
                    )
                    ->form([
                        DatePicker::make('payment_date')
                            ->required()
                            ->default(now()),

                        TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->minValue(0.01)
                            ->maxValue(fn (Invoice $record) => $record->balance_amount)
                            ->helperText(fn (Invoice $record) =>
                                'Outstanding: RM ' . number_format($record->balance_amount, 2)
                            ),

                        Select::make('method')
                            ->options([
                                'cash' => 'Cash',
                                'bank_transfer' => 'Bank Transfer',
                                'cheque' => 'Cheque',
                            ])
                            ->required(),
                    ])
                    ->action(function (array $data, Invoice $record) {
                        $record->payments()->create([
                            'payment_date' => $data['payment_date'],
                            'amount'       => $data['amount'],
                            'method'       => $data['method'],
                            'unit_id'      => $record->unit_id,
                        ]);

                        // refresh invoice totals / status
                        $record->refresh();
                    }),
            ])

            // Optional: keep row clickable to View
            ->recordUrl(fn (Invoice $record) =>
                InvoiceResource::getUrl('view', ['record' => $record])
            )

            ->defaultSort('issue_date', 'desc');
    }

}
