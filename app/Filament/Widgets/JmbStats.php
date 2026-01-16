<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Unit;
use App\Models\Payment;

class JmbStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Residents', 300)
                ->description('Total registered residents')
                ->icon('heroicon-o-users'),

            Stat::make('Units', 310)
                ->description('Total units')
                ->icon('heroicon-o-building-office'),

            Stat::make('Outstanding Payments','RM 2,040')
            ->description('Pending collections')
            ->icon('heroicon-o-banknotes'),
        ];
    }
}

