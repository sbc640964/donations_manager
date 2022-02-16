<?php

namespace App\Filament\Resources\ContactResource\RelationManagers;

use Closure;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\HasManyRelationManager;
use Filament\Resources\Table;
use Filament\Tables;

class DonationsInRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'donationsIn';

    protected static ?string $recordTitleAttribute = 'amount';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Radio::make('type')
                    ->reactive()
                    ->afterStateUpdated(function(Closure $set, Closure $get) {
                        if(!in_array($get('type'), [1,2])){
                            $set('months', 1);
                        }
                    })
                    ->options([
                        1 => "הוראת קבע בנקאית",
                        2 => "הוראת קבע באשראי",
                        3 => "תשלום חד פעמי באשראי",
                        4 => "תשלום חד פעמי בהעברה",
                        5 => "תשלום מזומן חד פעמי",
                    ]),
                Forms\Components\BelongsToSelect::make('donor_id')
                    ->relationship('donor', 'full_name')
                    ->searchable(),
                Forms\Components\TextInput::make('amount')
                    ->numeric(),
                Forms\Components\TextInput::make('months')
                    ->hidden(fn(Closure $get) => !in_array($get('type'), [1,2]) && !is_null($get('type')))
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
                //
            ])
            ->filters([
                //
            ]);
    }
}
