<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $guarded = [];

    protected $appends = [
        'total'
    ];

    public function donor()
    {
        return $this->belongsTo(Contact::class, 'donor_id');
    }

    public function fundRaiser()
    {
        return $this->belongsTo(Contact::class, 'fund_raiser_id');
    }

    public function getTotalAttribute() : int
    {
        return $this->amount * $this->months;
    }

}
