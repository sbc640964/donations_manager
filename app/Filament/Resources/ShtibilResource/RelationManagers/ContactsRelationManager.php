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

    protected static ?string $label = 'איש קשר';

    protected static ?string $pluralLabel = 'אנשי קשר';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')->label('שם פרטי')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')->label('משפחה')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tel')->label('טלפון')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')->label('נייד')
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')->label('כתובת')
                    ->required()
                    ->maxLength(255),

                Forms\Components\BelongsToSelect::make('city')->label('עיר')
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
                Tables\Columns\TextColumn::make('first_name')->label('משפחה'),
                Tables\Columns\TextColumn::make('last_name')->label('שם פרטי'),
                Tables\Columns\TextColumn::make('tel')->label('טלפון'),
                Tables\Columns\TextColumn::make('phone')->label('נייד'),
                Tables\Columns\TextColumn::make('address')->label('כתובת'),
                Tables\Columns\BooleanColumn::make('donations_count')
                    ->counts('donations')
                    ->label('תרם'),
            ])
            ->filters([
                //
            ]);
    }
}
