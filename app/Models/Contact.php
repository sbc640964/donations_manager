<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    protected $appends = [
        'full_name'
    ];

    public function father(){
        return $this->belongsTo(Contact::class);
    }

    public function fatherInLaw(){
        return $this->belongsTo(Contact::class);
    }

    public function shtibil(){
        return $this->belongsTo(Shtibil::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'donor_id');
    }

    public function donationsIn()
    {
        return $this->hasMany(Donation::class, 'fund_raiser_id');
    }

    public function getShortFullNameAttribute()
    {
        $name = $this->last_name;

        if($this->first_name){
            $name .= " $this->first_name";
        }

        return $name;
    }


//    public function setFirstNameAttribute($value)
//    {
//        $this->attributes['full_name'] = 'clkmlm';
//        return $value;
//    }
//
//    public function setLastNameAttribute($value)
//    {
//        $this->full_name = $this->first_naem . ' ' . $value;
//    }
}
