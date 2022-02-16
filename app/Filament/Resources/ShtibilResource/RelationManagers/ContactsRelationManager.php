<?php

namespace App\Filament\Resources\ShtibilResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class ContactsRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'contacts';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tel')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->maxLength(255),

                Forms\Components\BelongsToSelect::make('city')
                    ->relationship('city', 'name')
                    ->searchable(),

//                Forms\Components\BelongsToSelect::make('father')
//                    ->relationship('father', 'first_name'),
//
//                Forms\Components\BelongsToSelect::make('father_in_law')
//                    ->relationship('fatherInLaw', 'first_name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('last_name'),
                Tables\Columns\TextColumn::make('first_name'),
                Tables\Columns\TextColumn::make('tel'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('address'),
            ])
            ->filters([
                //
            ]);
    }
}
