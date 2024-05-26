<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All User'),
            'admin' => Tab::make('Admins')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas(
                    'role',
                    function ($q) {
                        $q->where('name', 'admin');
                    }
                )),
            'vendors' => Tab::make('Vendor')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas(
                    'role',
                    function ($q) {
                        $q->where('name', 'vendor');
                    }
                )),
            'guests' => Tab::make('Guests')
                ->modifyQueryUsing(fn (Builder $query) => $query->whereHas(
                    'role',
                    function ($q) {
                        $q->where('name', 'guest');
                    }
                )),
        ];
    }
}
