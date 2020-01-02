<?php

namespace App\Hosptialization;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;


class Hospitalization extends Model
{
    use SoftDeletes;
    use UUId;

    
    protected $fillable =
     [
    	'name',
    	'email',
    	'password'
    ];

      protected $with=
    [
        'profilePicture',
        'video',
        'address',
        'telephone',
        'location'
    ];

    $hidden =
    [
        'email',
        'password'
    ];

    public function profilePicture(){
    	return this->hasMany(Picture::class);
    }


	public function video(){
    	return this->hasOne(Video::class);
    } 

    public function address(){
    	return this->hasMany(Address::class);
    } 


    public function telephone(){
    	return this->hasMany(Telephone::class);
    }


    public function location(){
    	return this->hasMany(Location::class);
    }    
}
