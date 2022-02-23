<?php

namespace App\Filament\FormsComponents;

use Freelancehunt\Validators\CreditCard;
use Closure;
use Filament\Forms;


class CreateCard
{
    static public function fields($show = true, $inForm = true)
    {
        if(!$show) return [];

        return [
            Forms\Components\TextInput::make('card')->label('כרטיס')
                ->required()
                ->hidden(fn(Closure $get) => $inForm && !in_array($get('type'), [2,3]))
                ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                    ->pattern("0000-0000-0000-0000")
                    ->numeric()
                )->rules([
                    function() {
                        return function (string $attribute, $value, Closure $fail)
                        {
                            if(!($card = CreditCard::validCreditCard($value))['valid']){
                                if(!Validations::checkIsracard($card)){
                                    return $fail("מס' הכרטיס לא תקין");
                                }
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
                ->hidden(fn(Closure $get) => $inForm && !in_array($get('type'), [2,3]))
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
                ->helperText('שים לב! תעודת זהות ישראלית בלבד, טפסים אחרים שמרו בצד')
                ->rules([
                    function () {
                        return function (string $attribute, $value, Closure $fail) {
                            settype($value, 'string');
                            $sumTable = array(
                                array(0,1,2,3,4,5,6,7,8,9),
                                array(0,2,4,6,8,1,3,5,7,9));
                            $sum = 0;
                            $flip = 0;
                            for ($i = strlen($value) - 1; $i >= 0; $i--) {
                                $sum += $sumTable[$flip++ & 0x1][$value[$i]];
                            }
                            if($sum % 10 !== 0){
                                $fail("מס' תעודת הזהות אינה תקינה");
                            }
                        };
                    }
                ])
                ->hidden(fn(Closure $get) => $inForm && !in_array($get('type'), [2,3])),

            Forms\Components\TextInput::make('day')->label('יום גבייה בחודש')
                ->required()
                ->hidden(fn(Closure $get) => $inForm && !in_array($get('type'), [2,3]))
                ->mask(fn (Forms\Components\TextInput\Mask $mask) => $mask
                    ->numeric()
                ),
        ];
    }
}
