<?php

namespace App\Filament\Resources;

use App\Enums\UserType;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $title = 'User Management';

    protected static ?string $navigationLabel = 'User Management';

    protected ?string $heading = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')->required()->email(),
                Select::make('status')
                    ->options(UserType::class),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('guestDetails.room_number')
                    ->default('N/A')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role')
                    ->sortable()
                    ->searchable()
                    ->label('Role')
                    ->getStateUsing(function ($record) {
                        if ($record->is_admin) {
                            return 'Admin';
                        }

                        return $record->role->getLabel();
                    }),
                // SelectColumn::make('role')->disabled()
                //     ->options(UserType::class)
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                \Filament\Tables\Actions\Action::make('editGuestDetails')
                    ->label('Edit Guest Details')
                    ->icon('heroicon-m-pencil-square')
                    // ->iconButton()
                    ->action(function (User $record, array $data) {
                        if ($record->guestDetails) {
                            $record->guestDetails->update($data);
                        } else {
                            $record->guestDetails()->create($data);
                        }
                    })
                    ->form([
                        // Forms\Components\TextInput::make('phone')
                        //     // ->required()
                        //     ->maxLength(255)
                        //     ->label('Phone')
                        //     ->default(fn (User $record) => $record->guestDetails?->phone),
                        Forms\Components\TextInput::make('room_number')
                            // ->required()
                            ->maxLength(255)
                            ->label('Room Number')
                            ->default(fn (User $record) => $record->guestDetails?->room_number),
                        Forms\Components\TextInput::make('occupency')
                            ->integer()
                            // ->required()
                            ->maxLength(255)
                            ->label('Occupency')
                            ->default(fn (User $record) => $record->guestDetails?->occupency),
                    ])->slideOver()
                    ->visible(fn (User $record) => $record->role->value == 0 && ! $record->is_admin),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
