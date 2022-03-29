<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    use HasFactory;
    protected $appends= ['_links'];
    protected $table = 'real_state';
    protected $fillable = [
        'title',
        'description',
        'price',
        'bedrooms',
        'bathrooms',
        'property_area',
        'total_property_area',
        'content',
        'slug',
        'user_id',

    ];

    public function getLinksAttribute()
    {
        return [
          'href' =>  route('real_state.real-state.show',[ 'realState' => $this->id]),
           'rel' => 'Imoveis', 
        ];
        
    }

    public function getThumbAtrribute()
    {
        $thumb = $this->photos()where('is_thumb',true);
        
        if(!$thumb->count()){
            return null;
        }
        return $thumb->first()->photo;
    }
    
    
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
    public function categories() {
        return $this->belongsToMany('App\Models\Category', 'real_state_categories');
    }

    public function photos() {
        return $this->hasMany('App\Models\RealStatePhoto');
    }

    public function addresses(){
        return $this->belongsTo('App\Models\Address');
    }
}
