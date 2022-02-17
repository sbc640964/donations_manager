<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

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
                    ->columnSpan(2)
                    ->maxLength(255),

                Forms\Components\BelongsToSelect::make('city_id')
                    ->reactive()
                    ->afterStateUpdated(fn (\Closure $set) => $set('shtibil_id', null))
                    ->relationship('city', 'name'),

                Forms\Components\BelongsToSelect::make('shtibil_id')
                    ->relationship('shtibil', 'name', fn($query, \Closure $get) => $query->where('city_id', $get('city_id')))
                    ->searchable(),

//                Forms\Components\BelongsToSelect::make('father')
//                    ->searchable()
//                    ->relationship('father', 'last_name'),
//
//                Forms\Components\Select::make('father_in_law')
//                    ->searchable()
//                    ->columnSpan(2)
//                    ->getSearchResultsUsing(
//                        fn (string $query) => Contact::where('last_name', 'like', "%{$query}%")
//                            ->OrWhere('first_name', 'like', "%{$query}%")
//                            ->limit(50)
//                            ->get()
//                            ->pluck('full_name', 'id')
//                    )
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
                Tables\Columns\TextColumn::make('city.name')->sortable(),
                Tables\Columns\TextColumn::make('address'),
                Tables\Columns\TextColumn::make('shtibil.name'),
                Tables\Columns\TextColumn::make('father'),
                Tables\Columns\TextColumn::make('father_in_law'),
//                Tables\Columns\TextColumn::make('created_at')
//                    ->dateTime(),
//                Tables\Columns\TextColumn::make('updated_at')
//                    ->dateTime(),
            ])
            ->filters([

                Tables\Filters\Filter::make('s')
                    ->form([
                        Forms\Components\TextInput::make('search'),
                    ])->query(fn($query, $data) => $query->when(
                        $data['search'],
                        fn ($query, $search) => $query->where('full_name', 'like', "%$search%"),
                    )),
                Tables\Filters\MultiSelectFilter::make('city')
                    ->relationship('city', 'name'),

                Tables\Filters\MultiSelectFilter::make('shtibil')
                    ->relationship('shtibil', 'name'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DonationsRelationManager::class,
            RelationManagers\DonationsInRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
