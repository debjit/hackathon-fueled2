<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GiftResource\Pages;
use App\Models\Gift;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GiftResource extends Resource
{
    protected static ?string $model = Gift::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('url')->prefix('URL'),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('₹')
                    ->maxValue(42949672.95),
                // ->money('INR'),
                Forms\Components\Toggle::make('is_completed')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user'),
                Forms\Components\Textarea::make('details')
                    ->maxLength(65535)
                    ->columnSpan('full'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('price')
                    ->money('INR')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_completed')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGifts::route('/'),
            'create' => Pages\CreateGift::route('/create'),
            'edit' => Pages\EditGift::route('/{record}/edit'),
        ];
    }
}
