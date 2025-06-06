<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesResource\Pages;
use App\Filament\Resources\SalesResource\RelationManagers;
use App\Models\Sales;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Car;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalesResource extends Resource
{
    protected static ?string $model = Sales::class;
    protected static ?string $navigationGroup = 'Transaction';

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('car_id')
                ->label('Car Model ')
                ->relationship('car', 'model')
                ->options(
                    Car::where('status', 'available')->pluck('model', 'id')
                )
                ->required()
                ->searchable()
                ->preload()
                ->live()
                ->afterStateUpdated(function($state,Forms\Set $set){
                    $car =Car::find($state);
                    $set ('sale_price',$car?->price ?? 0);
                }),
                Forms\Components\Select::make('customer_id')
                ->relationship('customer','name')
                ->label('Customer Name')
                ->required(),
                Forms\Components\Select::make('user_id')
                ->relationship('user','name')
                ->default(auth()->id())
                ->disabled()
                ->dehydrated()
                // ->disabled(fn (string $context) => $context === 'edit')
                
                ->label('Sales By')
                ->required(),
                Forms\Components\TextInput::make('sale_price')
                ->label('Sale Price')
                ->required()
                ->readOnly(),
                Forms\Components\DatePicker::make('sale_date')
                ->label('Sale Date')
                ->default(now())
                ->required()
                ->date(),
            Forms\Components\Select::make('payment_status')
                ->label('Payment Status')
                ->options([
                    'pending'=> 'Pending',
                    'completed'=>'Completed',
                    'canceled'=>'Canceled',
                ])
                
                ->required(),

                Forms\Components\Select::make('payment_method')
                ->label('Payment Method')
                ->options([
                    'cash'=> 'Cash',
                    'credit_card'=>'Credit Card',
                    'bank_transfer'=>'Bank Transfer',

                ])
                ->required(),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               Tables\Columns\TextColumn::make('customer.name')
               ->label('Customer Name')
               ->sortable()
               ->searchable(),
               Tables\Columns\TextColumn::make('car.model')
               ->label('Car Model')
               ->sortable()
               ->searchable(),
               Tables\Columns\TextColumn::make('sale_price')
               ->label('Sale Price')
               ->sortable()
               ->searchable()
               ->money('USD',true),
                // Tables\Columns\TextColumn::make('sale_date')
                // ->label('Sale Date')
                // ->sortable()
                // ->date('d/m/Y')
                // ,
                Tables\Columns\TextColumn::make('payment_status')
                ->label('Payment Status')
                
                ->sortable()
                ->searchable()
                ->badge()
                ->color(fn(string $state):string=>match($state){
                    'pending'=>'warning',
                    'completed'=>'success',
                    'canceled'=>'danger',
                }),
            //    Tables\Columns\TextColumn::make('payment_method')
            //    ->label('Payment Method')
            //    ->sortable()
            //   -> searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'completed' => 'Completed',
                        'canceled' => 'Canceled',
                    ]),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options([
                        'cash' => 'Cash',
                        'credit_card' => 'Credit Card',
                        'bank_transfer' => 'Bank Transfer',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\DeleteAction::make()
                
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
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSales::route('/create'),
            'edit' => Pages\EditSales::route('/{record}/edit'),
        ];
    }
}
