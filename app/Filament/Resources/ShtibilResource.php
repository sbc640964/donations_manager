<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShtibilResource\Pages;
use App\Filament\Resources\ShtibilResource\RelationManagers;
use App\Models\Shtibil;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ShtibilResource extends Resource
{
    protected static ?string $model = Shtibil::class;

    protected static ?string $navigationIcon = 'heroicon-o-library';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\BelongsToSelect::make('city_id')
                    ->relationship('city', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('name')->sortable(),
                Tables\Columns\TextColumn::make('city.name'),
                Tables\Columns\TextColumn::make('contacts_count')->counts('contacts')
//                Tables\Columns\TextColumn::make('created_at')
//                    ->dateTime(),
//                Tables\Columns\TextColumn::make('updated_at')
//                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('city')
                    ->relationship('city', 'name')
                    ->searchable(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ContactsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
//            'index' => Pages\ManageShtibil::route('/'),
            'index' => Pages\ListShtibils::route('/'),
            'create' => Pages\CreateShtibil::route('/create'),
            'edit' => Pages\EditShtibil::route('/{record}/edit'),
        ];
    }
}
