<?php

namespace App\Filament\Resources\ExpenseTrackerResource\Pages;

use App\Filament\Resources\ExpenseTrackerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpenseTracker extends EditRecord
{
    protected static string $resource = ExpenseTrackerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
