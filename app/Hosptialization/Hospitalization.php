<?php

namespace App\Hosptialization;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\User\ResetPasswordNotification as UserResetPasswordNotification;

class Hospitalization extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;
    use UUId;

    protected $guard = 'hospitalization';

    
    protected $fillable =
     [
    	'name',
    	'email',
    	'password',
        'slug'

    ];

      protected $with=
    [
        'profilePicture',
        'video',
        'address',
        'telephone',
        'location',
    ];

    $hidden =
    [
        'email',
        'password',
        'remember_token'
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

     /**
     * Automatically creates hash for the user password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token) { 
        $this->notify(new UserResetPasswordNotification($token));
    }  
}
