<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class UsersOverview extends StatsOverviewWidget
{

    // public ?Model $record = null;

    protected static ?string $pollingInterval = null;

    use InteractsWithPageTable;

    protected function getStats(): array
    {
        return [
            // $this->record->count()
            // Stat::make('Total Products', $this->getPageTableQuery()->count()),
            Stat::make('Total Products', User::count()),
            Stat::make('Total Guests', User::where('is_admin',0)->where('role',0)->count()),
            Stat::make('Total Vendors', User::where('is_admin',0)->where('role',1)->count()),
        ];
    }
}
