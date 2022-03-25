<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'slug',
        'real_state_id'
    ];

    public function realStates()
    {
        return $this->belongsToMany('App\Models\RealState','real_state_categories');
    }
}
