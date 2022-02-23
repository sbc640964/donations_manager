<?php

namespace App\Filament\FormsComponents;

use App\Models\Contact;
use App\Models\Donation;
use Closure;
use Filament\Forms;
use Illuminate\Support\Facades\DB;


class CreateDonation
{
    static public function fields($withCard = true, $withDonor = false, $withFundRaiser = true)
    {
        $fields = [
            Forms\Components\Radio::make('type')->label('סוג')
                ->reactive()
                ->columnSpan(2)
                ->afterStateUpdated(function(Closure $set, Closure $get) {
                    if(!in_array($get('type'), [1,2,6])){
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
                    6 => "שקים",
                ])
                ->default(2),
        ];

        if($withDonor){
            $fields[] =
                Forms\Components\Select::make('donor_id')->label('תורם')
                    ->getSearchResultsUsing(fn($query) => Contact::where('full_name', 'like', "%$query%")->pluck('full_name', 'id'))
                    ->getOptionLabelUsing(fn($value) => Contact::find($value)?->full_name ?? null)
                    ->searchable();
        }

        if($withFundRaiser){
            $fields[] =
                Forms\Components\Select::make('fund_raiser_id')->label('מתרים')
                    ->getSearchResultsUsing(fn($query) => Contact::where('full_name', 'like', "%$query%")->pluck('full_name', 'id'))
                    ->getOptionLabelUsing(fn($value) => Contact::find($value)?->full_name ?? null)
                    ->searchable();
        }

        $fields =  array_merge($fields, [
            Forms\Components\TextInput::make('amount')->label('סכום')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('months')->label('מס\' חודשים')
                ->hidden(fn(Closure $get) => !in_array($get('type'), [1,2,6]) && !is_null($get('type')))
                ->default(60)
                ->numeric(),
            //Forms\Components\FileUpload::make('file'),
            Forms\Components\Toggle::make('done')->columnSpan(2)->label('בוצע'),

            ...CreateCard::fields($withCard, true),

            Forms\Components\Textarea::make('not')->columnSpan(2)->label('הערה'),
        ]);

        return $fields;
    }

    static public function action(Contact $record, $data)
    {
        DB::transaction(function () use ($data, $record) {

            $card_donation = null;
            $donation_data = collect($data)->only(['type', 'fund_raiser_id', 'amount', 'months', 'done', 'not'])->all();


            if(in_array($donation_data['type'], [2,3])){
                $card_donation = collect($data)->only(['card', 'exp', 'day', 'password'])->all();
            }

            $donation = $record->donations()->create($donation_data);

            if(in_array($donation_data['type'], [2,3])){
                $donation->card()->create($card_donation);
            }

        });
    }

    static public function can()
    {

    }
}
