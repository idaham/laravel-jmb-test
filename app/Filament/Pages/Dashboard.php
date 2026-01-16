<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\JmbStats;

class Dashboard extends BaseDashboard
{
    public function getHeaderWidgets(): array
    {
        return [];
    }
    public function getWidgets(): array
    {
        return [
            JmbStats::class,
        ];
    }

}
