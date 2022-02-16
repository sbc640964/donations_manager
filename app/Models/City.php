<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'name'
    ];

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function shtibils()
    {
        return $this->hasMany(Shtibil::class);
    }
}
