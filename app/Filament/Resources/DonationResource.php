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

class DonationResource extends Resource
{
    protected static ?string $model = Donation::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $label = 'תרומה';

    protected static ?string $pluralLabel = 'תרומות';

    public static function form(Form $form): Form
    {
        return $form
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
