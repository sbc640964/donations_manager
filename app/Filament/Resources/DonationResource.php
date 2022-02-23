<?php

namespace App\Filament\Resources;

use App\Filament\FormsComponents\CreateCard;
use App\Filament\FormsComponents\CreateDonation;
use App\Filament\Resources\DonationResource\Pages;
use App\Filament\Resources\DonationResource\RelationManagers;
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
            ->schema(
                CreateDonation::fields(false, true)
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('donor.short_full_name')->label('תורם')->sortable()->searchable(['first_name', 'last_name']),
                Tables\Columns\TextColumn::make('id')->label('מזהה')->sortable()->searchable(),
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
                    ->form(CreateCard::fields(true, false))
                    ->action(function (Donation $record, $data) {
                        $record->card()->create($data);
                    })
                    ->hidden(fn(Donation $record) => !in_array($record->type, [2,3]) || !is_null($record->card))
                    ->requiresConfirmation()
                    ->modalWidth('3xl')
                    ->color('primary')
                    ->modalHeading('הוספת כרטיס אשראי')
                    ->modalSubheading('פרטי אשראי עבור התרומה'),

                Tables\Actions\LinkAction::make('define_infinity')->label('ללא הגבלה')
                    ->action(function (Donation $record) {
                        $record->setInfinity();
                    })
//                    ->modalButton('הוסף תרומה')
                    ->hidden(fn(Donation $record) => $record->months != 60 || request()->user()->cannot('update', $record))
//                    ->requiresConfirmation()
//                    ->modalWidth('3xl')
                    ->color('success')
                    ->requiresConfirmation(),
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
