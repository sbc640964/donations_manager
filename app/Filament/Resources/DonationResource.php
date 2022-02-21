<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DonationResource\Pages;
use App\Filament\Resources\DonationResource\RelationManagers;
use App\Models\Contact;
use App\Models\Donation;
use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Freelancehunt\Validators\CreditCard;

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $label = 'תרומה';

    protected static ?string $pluralLabel = 'תרומות';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(3)
            ->schema([
                Forms\Components\Radio::make('type')
                    ->reactive()
                    ->afterStateUpdated(function(Closure $set, Closure $get) {
                        if(!in_array($get('type'), [1,2,6])){
                            $set('months', 1);
                        }
                    })
                    ->options([
                        1 => "הוראת קבע בנקאית",
                        2 => "הוראת קבע באשראי",
                        3 => "תשלום חד פעמי באשראי",
                        4 => "תשלום חד פעמי בהעברה",
                        5 => "תשלום מזומן חד פעמי",
                        6 => "שקים",
                    ])
                    ->default(2),

                Forms\Components\BelongsToSelect::make('donor_id')
                    ->relationship('donor', 'full_name')
                    ->searchable(),

                Forms\Components\BelongsToSelect::make('fund_raiser_id')
                    ->relationship('fundRaiser', 'full_name')
                    ->searchable(),

                Forms\Components\TextInput::make('amount')
                    ->numeric(),

                Forms\Components\TextInput::make('months')
                    ->hidden(fn(Closure $get) => !in_array($get('type'), [1,2,6]) && !is_null($get('type')))
                    ->default(60)
                    ->numeric(),

                //Forms\Components\FileUpload::make('file'),
                Forms\Components\Toggle::make('done')->columnSpan(2),

                Forms\Components\Textarea::make('not'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('donor.short_full_name')->label('תורם')->sortable()->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('donor.city.name')->label('עיר')->searchable(),
                Tables\Columns\TextColumn::make('donor.shtibil.name')->label('שטיבל')->searchable(),
                Tables\Columns\TextColumn::make('type')->label('סוג התרומה')->enum([
                    1 => "הוראת קבע בנקאית",
                    2 => "הוראת קבע באשראי",
                    3 => "תשלום חד פעמי באשראי",
                    4 => "תשלום חד פעמי בהעברה",
                    5 => "תשלום מזומן חד פעמי",
                    6 => "שקים",
                ]),
                Tables\Columns\TextColumn::make('amount')->label('סכום')
                    ->money('ILS', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('months')->label("מס' חודשים/תשלומים"),
                Tables\Columns\TextColumn::make('total')->label('סה"כ')->money('ILS', true),
                Tables\Columns\BooleanColumn::make('done')->label('בוצע'),
            ])
            ->filters([
                //
            ])
            ->pushActions([
                Tables\Actions\LinkAction::make('add_card')->label('הוסף כרטיס')
                    ->form([
                        Forms\Components\TextInput::make('card')->label('כרטיס')
                            ->required()
                            ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                                ->pattern("0000-0000-0000-0000")
                                ->numeric()
                            )->rules([
                                function() {
                                    return function (string $attribute, $value, Closure $fail)
                                    {
                                        if(!($card = CreditCard::validCreditCard($value))['valid']){
                                            return $fail("מס' הכרטיס לא תקין");
                                        }
                                    };
                                }
                            ]),

                        Forms\Components\TextInput::make('exp')->label('תוקף')
                            ->required()
                            ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                                ->pattern("00/00")
                                ->numeric()
                            )
                            ->rules([
                                function() {
                                    return function (string $attribute, $value, Closure $fail)
                                    {
                                        list($month, $year) = str_split($value, 2);

                                        $year = "20" . $year;

                                        if(!CreditCard::validDate($year, $month)){
                                            return $fail("התוקף לא תקין");
                                        }
                                    };
                                }
                            ]),

                        Forms\Components\TextInput::make('password')->label('תעודת זהות')
                            ->required(),
                        Forms\Components\TextInput::make('day')->label('יום גבייה בחודש')
                        ->required()
                            ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                                ->numeric()
                            ),
                    ])
                    ->action(function (Donation $record, $data) {
                        $record->card()->create($data);
                    })
                    ->hidden(fn(Donation $record) => !in_array($record->type, [2,3]) || !is_null($record->card))
                    ->requiresConfirmation()
                    ->modalWidth('3xl')
                    ->color('primary')
                    ->modalHeading('Add card')
                    ->modalSubheading('Add card to donation'),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDonations::route('/'),
            'create' => Pages\CreateDonation::route('/create'),
            'edit' => Pages\EditDonation::route('/{record}/edit'),
        ];
    }

    public function getHeaderWidgets()
    {
        return [
            DonationResource::getWidgets()
        ];
    }
}
