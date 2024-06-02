<?php

namespace App\Filament\User\Widgets;

use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $user = auth()->user();

        return [
            Stat::make('Room Details', $user->details->room_details ?? 'N/A')
                ->color('success'),
            Stat::make('User Occupency', $user->details->occupency ?? 'N/A'),
            // Stat::make('Average time on page', '3:12'),
            // Stat::make('Unique views', '192.1k')
            //     ->description('32k increase')
            //     ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
        ];
    }
}
