<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpenseTrackerResource\Pages;
use App\Models\ExpenseTracker;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExpenseTrackerResource extends Resource
{
    protected static ?string $model = ExpenseTracker::class;

    protected static ?string $navigationGroup = 'Expense Management';

    protected static ?string $navigationLabel = 'Bills';

    protected static ?string $navigationIcon = 'heroicon-o-currency-rupee';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Toggle::make('is_paid')
                    ->onColor('success')
                    ->offColor('danger')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user'),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->prefix('INR')
                    ->required()
                    ->maxValue(42949672.95),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\IconColumn::make('is_paid')
                    ->boolean(),
                Tables\Columns\TextColumn::make('title'),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_paid'),
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
            'index' => Pages\ListExpenseTrackers::route('/'),
            'create' => Pages\CreateExpenseTracker::route('/create'),
            'edit' => Pages\EditExpenseTracker::route('/{record}/edit'),
        ];
    }
}
