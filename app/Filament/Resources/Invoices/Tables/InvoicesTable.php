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
use Filament\Schemas\Components\Utilities\Get;

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
                    ->searchable(
                        query: function ($query, string $search) {

                            $normalized = strtoupper(trim($search));
                            $parts = preg_split('/[-\s\/]+/', $normalized);

                            $query->whereHas('unit', function ($q) use ($normalized, $parts) {
                                $q->whereNull('deleted_at')
                                  ->where(function ($q) use ($normalized, $parts) {

                                      // 1️⃣ Loose match (single token: A, G, 1)
                                      $q->where('block', 'like', "%{$normalized}%")
                                        ->orWhere('floor', 'like', "%{$normalized}%")
                                        ->orWhere('unit_no', 'like', "%{$normalized}%");

                                      // 2️⃣ Two-part searches (A-G, G-1)
                                      if (count($parts) === 2) {
                                          [$p1, $p2] = $parts;

                                          $q->orWhere(function ($q) use ($p1, $p2) {
                                              // block-floor
                                              $q->where('block', $p1)
                                                ->where('floor', $p2);
                                          });

                                          $q->orWhere(function ($q) use ($p1, $p2) {
                                              // floor-unit
                                              $q->where('floor', $p1)
                                                ->where('unit_no', $p2);
                                          });
                                      }

                                      // 3️⃣ Three-part search (A-G-1)
                                      if (count($parts) === 3) {
                                          [$b, $f, $u] = $parts;

                                          $q->orWhere(function ($q) use ($b, $f, $u) {
                                              $q->where('block', $b)
                                                ->where('floor', $f)
                                                ->where('unit_no', $u);
                                          });
                                      }
                                  });
                            });
                        }
                    )
                    ->sortable(query: function ($query, string $direction) {
                        $query
                            ->join('units', 'units.id', '=', 'invoices.unit_id')
                            ->whereNull('units.deleted_at')
                            ->orderBy('units.block', $direction)
                            ->orderBy('units.floor', $direction)
                            ->orderBy('units.unit_no', $direction)
                            ->select('invoices.*');
                    }),

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

            ->actions([
                ViewAction::make(),

                Action::make('pay')
                    ->label('Pay')
                    ->icon('heroicon-o-banknotes')
                    ->color('success')
                    ->visible(fn (Invoice $record) => $record->canAcceptPayment())
                    ->form([
                        DatePicker::make('payment_date')
                            ->label('Payment Date')
                            ->required()
                            ->default(now()),

                        TextInput::make('amount')
                            ->label('Amount')
                            ->numeric()
                            ->required()
                            ->minValue(0.01)
                            ->maxValue(fn (Invoice $record) => $record->balance_amount)
                            ->helperText(fn (Invoice $record) =>
                                'Outstanding: RM ' . number_format($record->balance_amount, 2)
                            ),

                        Select::make('method')
                            ->label('Payment Method')
                            ->options([
                                'cash'     => 'Cash',
                                'transfer' => 'Bank Transfer', // ✅ MATCH DB ENUM
                                'cheque'   => 'Cheque',
                                'online'   => 'Online',
                            ])
                            ->required()
                            ->live(),

                        TextInput::make('reference_no')
                            ->label('Reference No')
                            ->placeholder('Bank ref / cheque no')
                            ->maxLength(255)
                            ->visible(fn (Get $get) =>
                                in_array($get('method'), ['transfer', 'cheque', 'online'])
                            )
                            ->required(fn (Get $get) =>
                                in_array($get('method'), ['transfer', 'cheque', 'online'])
                            ),

                        TextInput::make('remarks')
                            ->label('Remarks')
                            ->columnSpanFull(),
                    ])
                    ->action(function (array $data, Invoice $record) {
                        $record->payments()->create([
                            'payment_date' => $data['payment_date'],
                            'amount'       => $data['amount'],
                            'method'       => $data['method'],
                            'reference_no' => $data['reference_no'] ?? null,
                            'remarks'      => $data['remarks'] ?? null,
                            'unit_id'      => $record->unit_id,
                            'received_by'  => auth()->id(), // ✅ AUDIT-SAFE
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
