<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Payment Details')
                ->columns(2)
                ->schema([
                    TextEntry::make('receipt_no')
                        ->label('Receipt No'),

                    TextEntry::make('payment_date')
                        ->label('Payment Date')
                        ->date(),

                    TextEntry::make('amount')
                        ->label('Amount')
                        ->money('MYR'),

                    TextEntry::make('method')
                        ->label('Method')
                        ->badge(),

                    TextEntry::make('reference_no')
                        ->label('Reference No')
                        ->placeholder('-'),

                    TextEntry::make('remarks')
                        ->label('Remarks')
                        ->columnSpanFull()
                        ->placeholder('-'),
                ]),

            Section::make('Context')
                ->columns(2)
                ->schema([
                    TextEntry::make('invoice.invoice_no')
                        ->label('Invoice No'),

                    TextEntry::make('invoice.unit.display_name')
                        ->label('Unit'),

                    TextEntry::make('receiver.name')
                        ->label('Received By')
                        ->placeholder('-'),

                    TextEntry::make('created_at')
                        ->label('Recorded At')
                        ->dateTime(),
                ]),
        ]);
    }
}
