<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $guarded = [];

    protected $appends = [
        'total',
    ];

    protected $with = [
        'card'
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
        return $this->amount * ($this->months ?? 60);
    }

    public function card()
    {
        return $this->hasOne(Card::class, 'donation_id');
    }

    public function setInfinity()
    {
        $this->months = null;
        $this->save();
    }


}
