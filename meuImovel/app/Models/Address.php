<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'table_addresses';
    use HasFactory;

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function realState()
    {
        return $this->hasOne(RealState::class);
    }
}
