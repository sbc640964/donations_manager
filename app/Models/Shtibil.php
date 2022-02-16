<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shtibil extends Model
{
    protected $table = 'shtibils';

    protected $guarded = [];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'shtibil_id');

    }
}
