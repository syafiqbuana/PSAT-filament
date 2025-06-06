<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarsResource\Pages;
use App\Filament\Resources\CarsResource\RelationManagers;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpParser\Node\Stmt\Label;

class CarsResource extends Resource
{
    protected static ?string $model = Car::class;
    protected static ?string $navigationGroup = 'General Data';

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('brand')
                    ->required()
                    ->Label('Brand')
                    ->maxLength(255),
                Forms\Components\TextInput::make('model')
                    ->required()
                    ->Label('Model')
                    ->maxLength(255),
                Forms\Components\TextInput::make('year')
                    ->required()
                    ->Label('Year')
                    ->maxLength(4),
                Forms\Components\TextInput::make('color')
                    ->required()
                    ->Label('Color')
                    ->maxLength(255),
                Forms\Components\TextInput::make('license_plate')
                    ->required()
                    ->Label('License Plate')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_chassis')
                    ->required()
                    ->Label('No Chassis')
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_engine')
                    ->required()
                    ->Label('No Engine')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->label('Price')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(999999.99)
                    ->step(0.01),
                Forms\Components\Select::make('status')
                    ->required()
                    ->label('Status Car')
                    ->options([
                        'available'=>'Available',
                        'sold'=> 'Sold'
                    ])
                    ->default('available'),



                Forms\Components\Textarea::make('description')
                ->label('Description')
                    ->rows(3)
                    ->maxLength(66665)
                    ->columnSpan(2),

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('brand')
            ->label('Car Brand')
            ->sortable()
            ->searchable(),
            Tables\Columns\TextColumn::make('model')
            ->label('Car model')
            ->sortable()
            ->searchable(),
            Tables\Columns\TextColumn::make('price')
            ->label('Car Price')
            ->sortable()
            ->money('USD',true),
            Tables\Columns\TextColumn::make('status')
            ->label('Status')
            ->sortable()
            ->searchable()
            ->badge()
            ->color(fn(Car $record):string =>match ($record->status){
               'available'=>'success',
               'sold'=>'danger',
            }),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'available' => 'Available',
                        'sold' => 'Sold',
                    ])
                    ->label('Status'),
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->action(function (Car $record) {
                        $record->delete();
                    })
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-trash')
                    ->label('Delete '),
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
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCars::route('/create'),
            'edit' => Pages\EditCars::route('/{record}/edit'),
        ];
    }
}
