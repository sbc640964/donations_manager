<?php

namespace App\Filament\FormsComponents;

use Freelancehunt\Validators\CreditCard;
use Closure;
use Filament\Forms;


class CreateCard
{
    static public function fields($show)
    {
        if(!$show) return [];

        return [
            Forms\Components\TextInput::make('card')->label('כרטיס')
                ->required()
                ->hidden(fn(Closure $get) => !in_array($get('type'), [2,3]))
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
                ->hidden(fn(Closure $get) => !in_array($get('type'), [2,3]))
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
                ->required()
                ->hidden(fn(Closure $get) => !in_array($get('type'), [2,3])),

            Forms\Components\TextInput::make('day')->label('יום גבייה בחודש')
                ->required()
                ->hidden(fn(Closure $get) => !in_array($get('type'), [2,3]))
                ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                    ->numeric()
                ),
        ];
    }
}
