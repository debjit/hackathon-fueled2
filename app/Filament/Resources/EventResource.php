<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationGroup = 'Event Management';

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    // ->prefix('Starts')
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                Forms\Components\TimePicker::make('start_time')
                    ->prefix('Starts')
                    ->native(false)
                // ->displayFormat('d/m/Y')
                ,

                Forms\Components\TimePicker::make('end_time')
                    ->prefix('Ends')
                    ->native(false),
                // ->displayFormat('d/m/Y')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('tables_count')
                    ->counts('tables')
                    ->label('Tables'),
                TextColumn::make('date')
                // ->displayFormat('d/m/Y')
                ,

            ])
            ->filters([
                Filter::make('date'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TablesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
            'view' => Pages\ViewEvent::route('/{record}'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        logger($data);

        return $data;
    }
}
