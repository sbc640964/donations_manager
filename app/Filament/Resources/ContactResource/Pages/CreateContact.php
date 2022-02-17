<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use App\Models\City;
use Filament\Resources\Pages\CreateRecord;

class CreateContact extends CreateRecord
{
    protected static string $resource = ContactResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $city = City::find($data['city_id'])?->name ?? $data['city_id'];

        $full_name = $data['last_name'];

        if($data['first_name'] ?? false){
            $full_name .= ' ' . $data['first_name'];
        }

        $full_name .= ", {$data['address']}, $city";

        $data['full_name'] = $full_name;

        return $data;
    }
}
