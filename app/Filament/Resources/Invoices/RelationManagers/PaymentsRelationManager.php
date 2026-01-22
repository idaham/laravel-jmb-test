<?php

namespace App\Filament\Resources\Invoices\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    protected static ?string $title = 'Payments';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('receipt_no')
            ->paginated(false)
            ->defaultSort('payment_date', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('payment_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('receipt_no')
                    ->label('Receipt No')
                    ->searchable(),

                Tables\Columns\TextColumn::make('amount')
                    ->money('MYR')
                    ->alignRight(),

                Tables\Columns\TextColumn::make('method')
                    ->badge(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Recorded')
                    ->since(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Payment')
                    ->modalHeading('Add Payment')
                    ->form([
                        DatePicker::make('payment_date')
                            ->required(),

                        TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->minValue(0.01),

                        Select::make('method')
                            ->options([
                                'cash' => 'Cash',
                                'bank_transfer' => 'Bank Transfer',
                                'cheque' => 'Cheque',
                            ])
                            ->required(),
                    ])
                    ->disabled(fn () => $this->getOwnerRecord()->status === 'paid')
                    ->after(function () {
                        $this->getOwnerRecord()->refresh();
                    }),
            ])
            ->actions([
                Action::make('receipt')
                    ->label('Receipt')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => route('system.payments.receipt', $record))
                    ->openUrlInNewTab(),
            ])
            ->defaultSort('payment_date', 'desc')
            ->emptyStateHeading('No payments yet')
            ->emptyStateDescription('Payments recorded for this invoice will appear here.');
    }
}
