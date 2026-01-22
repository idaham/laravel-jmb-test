<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\InvoiceResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->visible(fn () => $this->record->status === 'draft'),

            Action::make('issueInvoice')
                ->label('Issue Invoice')
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->requiresConfirmation()
                ->modalHeading('Issue Invoice')
                ->modalDescription(
                    'Once issued, this invoice can no longer be edited.'
                )
                ->visible(fn () => $this->record->status === 'draft')
                ->action(fn () =>
                    $this->record->update(['status' => 'issued'])
                ),
        ];
    }

    public function getRelationManagers(): array
    {
        return [
            \App\Filament\Resources\Invoices\RelationManagers\PaymentsRelationManager::class,
        ];
    }

}
