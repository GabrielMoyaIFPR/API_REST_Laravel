<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;
    protected $table ='user_profile';
    
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'phone',
        'mobile_phone',
        'social_networks',
        'about',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
