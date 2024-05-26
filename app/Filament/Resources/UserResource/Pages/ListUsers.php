<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\Role;
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
                ->query(fn (Builder $query) => $this->findRole($query, Role::ADMIN)),
            'vendors' => Tab::make('Vendor')
                ->query(fn (Builder $query) => $this->findRole($query, Role::VENDOR)),
            'guests' => Tab::make('Guests')
                ->query(fn (Builder $query) => $this->findRole($query, Role::GUEST)),
        ];
    }

    private function findRole(Builder $query, string $role): Builder
    {
        return $query->whereHas('role', fn ($q) => $q->whereName($role));
    }
}
