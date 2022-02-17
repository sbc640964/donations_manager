<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Filament\Resources\ContactResource\RelationManagers;
use App\Models\Contact;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $label = 'איש קשר';

    protected static ?string $pluralLabel = 'אנשי קשר';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')->label('שם פרטי')
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
                    ->maxLength(255),

                Forms\Components\TextInput::make('address')->label('כתובת')
                    ->required()
                    ->columnSpan(2)
                    ->maxLength(255),

                Forms\Components\BelongsToSelect::make('city_id')->label('עיר')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(fn (\Closure $set) => $set('shtibil_id', null))
                    ->relationship('city', 'name'),

                Forms\Components\BelongsToSelect::make('shtibil_id')->label('שטיבל')
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
                Tables\Columns\TextColumn::make('last_name')->searchable(['first_name', 'full_name'])->label('משפחה'),
                Tables\Columns\TextColumn::make('first_name')->searchable()->label('שם פרטי'),
                Tables\Columns\TextColumn::make('tel')->label('טלפון'),
                Tables\Columns\TextColumn::make('phone')->label('נייד'),
                Tables\Columns\TextColumn::make('city.name')->sortable()->searchable()->label('עיר'),
                Tables\Columns\TextColumn::make('address')->label('כתובת'),
                Tables\Columns\TextColumn::make('shtibil.name')->searchable()->label('שטיבל'),
                Tables\Columns\BooleanColumn::make('donations_count')->counts('donations')->label('תרם'),
//                Tables\Columns\TextColumn::make('father'),
//                Tables\Columns\TextColumn::make('father_in_law'),
//                Tables\Columns\TextColumn::make('created_at')
//                    ->dateTime(),
//                Tables\Columns\TextColumn::make('updated_at')
//                    ->dateTime(),
            ])


            ->filters([
//                Tables\Filters\MultiSelectFilter::make('donations')
//                    ->options([
//                        'yes',
//                        'no'
//                    ])
//                    ->query(fn (Builder $query, $data): Builder => $query->{$data === 'yes' ? 'whereHas' : 'whereDoesntHave'}('donations'))
//                    ->label('מצב תרומה'),

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
            ])


            ->pushActions([
                Tables\Actions\LinkAction::make('add donation')->label('הוסף תרומה')
                    ->form([
                        Forms\Components\Radio::make('type')->label('סוג')
                            ->reactive()
                            ->columnSpan(2)
                            ->afterStateUpdated(function(Closure $set, Closure $get) {
                                if(!in_array($get('type'), [1,2])){
                                    $set('months', 1);
                                }
                            })
                            ->required()
                            ->options([
                                1 => "הוראת קבע בנקאית",
                                2 => "הוראת קבע באשראי",
                                3 => "תשלום חד פעמי באשראי",
                                4 => "תשלום חד פעמי בהעברה",
                                5 => "תשלום מזומן חד פעמי",
                            ])
                            ->default(2),

                        Forms\Components\Select::make('fund_raiser_id')->label('מתרים')
                            ->getSearchResultsUsing(fn($query) => Contact::where('full_name', 'like', "%$query%")->pluck('full_name', 'id'))
                            ->columnSpan(2)
                            ->searchable(),

                        Forms\Components\TextInput::make('amount')->label('סכום')
                            ->columnSpan(2)
                            ->numeric()
                            ->required(),

                        Forms\Components\TextInput::make('months')->label('מס\' חודשים')
                            ->hidden(fn(Closure $get) => !in_array($get('type'), [1,2]) && !is_null($get('type')))
                            ->columnSpan(2)
                            ->default(60)
                            ->numeric()
                            ->required(),
                        //Forms\Components\FileUpload::make('file'),
                        Forms\Components\Toggle::make('done')->columnSpan(2)->label('בוצע'),

                        Forms\Components\Textarea::make('not')->columnSpan(2)->label('הערה'),
                    ])
                    ->action(function (Contact $record, $data) {
                        $record->donations()->create($data);
                    })
                    ->requiresConfirmation()
                    ->modalWidth('3xl')
                    ->color('primary'),
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
