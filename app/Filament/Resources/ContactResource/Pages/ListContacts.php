<?php

namespace App\Filament\Resources\ContactResource\Pages;

use App\Filament\Resources\ContactResource;
use Filament\Resources\Pages\ListRecords;

class ListContacts extends ListRecords
{
    protected static string $resource = ContactResource::class;

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100, 250];
    }
}
