<?php

namespace App\Filament\Vendors\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ExpenseOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $user = auth()->user();

        return [
            Stat::make('Total Bill Amount', $user->expenses->sum('amount') ?? 'N/A')
                ->color('success'),
            Stat::make('Total unpaid Bill Amount', $user->expenses()->where('is_paid', 0)->sum('amount') / 100 ?? 'N/A')
                ->color('success'),
            Stat::make('Total Bills Nos: ', $user->expenses->count() ?? 'N/A')
                ->color('success'),
        ];
    }
}
