<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShoeResource\Pages;
use App\Filament\Resources\ShoeResource\RelationManagers;
use App\Models\Shoe;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShoeResource extends Resource
{
    protected static ?string $model = Shoe::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Fieldset::make('Details')
                ->schema([
                Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('IDR'),

                Forms\Components\FileUpload::make('thumbnail')
                ->image()
                ->required(),

                Forms\Components\Repeater::make('photos')
                ->relationship('photos')
                ->schema([
                    Forms\Components\FileUpload::make('photo')
                    ->required(),
                ]),

                Forms\Components\Repeater::make('sizes')
                ->relationship('sizes')
                ->schema([
                    Forms\Components\TextInput::make('size')
                    ->required(),
                ]),
                //

            ]),

                Fieldset::make('Additional')
                ->schema([
                    Forms\Components\TextArea::make('about')
                    ->required(),

                    Forms\Components\Select::make('is_popular')
                    ->options([
                        true=>'Popular',
                        false=>'Not Popular',
                    ])
                    ->required(),

                    Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                    Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                    Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->prefix('Qty'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListShoes::route('/'),
            'create' => Pages\CreateShoe::route('/create'),
            'edit' => Pages\EditShoe::route('/{record}/edit'),
        ];
    }
}
