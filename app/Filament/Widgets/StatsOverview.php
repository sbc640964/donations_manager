<?php

namespace App\Filament\Widgets;

use App\Models\Donation;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $totalDonations = Donation::where('amount', '>', 0)->count();

        $total = DB::table('donations')->selectRaw('SUM(amount * months) as total')->first()?->total ?? 0;

        return [
            Card::make('Total donations', $totalDonations),
            Card::make('Total', $total),
        ];
    }
}
