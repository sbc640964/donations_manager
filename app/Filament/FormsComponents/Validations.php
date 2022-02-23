<?php

namespace App\Filament\FormsComponents;

class Validations
{
    static public function checkIsracard($id){

        dd($id);

        if(gettype($id) === 'integer'){
            $id = settype($id, 'string');
        }

        $lenId = strlen($id);

        if($lenId > 9 || $lenId < 8){
            return false;
        }

        if($lenId === 8){
            $id = '0' . $id;
        }

        $counter = 9;

        $result = 0;

        foreach(str_split($id) as $digit){
            $result += ($digit * $counter);
            $counter --;
        }

        return $counter % 11 === 0;
    }

}
