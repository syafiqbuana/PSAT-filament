<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomersResource\Pages;
use App\Filament\Resources\CustomersResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomersResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationGroup = 'General Data';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->label('Customer Name'),
                Forms\Components\TextInput::make('phone')
                ->required()
                ->label('Phone Number')
                ->tel(),
                Forms\Components\TextInput::make('email')
                ->required()
                ->label('Email')
                ->email()
                ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('address')
                ->required()
                ->label('Address')
                ->rows(3)
                ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                ->label('Customer Name')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                ->label('Phone Number')
                ->searchable(),
                Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ,
                Tables\Columns\TextColumn::make('address')
                ->label('Address')
                ->limit(50)
                ->searchable()
                ->wrap(),
                

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomers::route('/create'),
            'edit' => Pages\EditCustomers::route('/{record}/edit'),
        ];
    }
}
