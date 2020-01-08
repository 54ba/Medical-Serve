<?php

namespace App\Models\Hospitalization;

use App\Models\Hospitalization\Lab;
use App\Models\Hospitalization\Doctor;
use App\Models\Hospitalization\Hospital;
use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\User\ResetPasswordNotification as UserResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use App\Models\Information\Picture;
use App\Models\Information\Address;
use App\Models\Information\Location;
use App\Models\Information\Telephone;
use App\Models\Information\Video;

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

    protected $hidden =
    [
        'email',
        'password',
        'remember_token'
    ];

    protected $casts = [
        'id' => 'string'
    ];
    public $incrementing = false;

    public function profilePicture(){
    	return $this->hasOne(Picture::class);
    }


	public function video(){
    	return $this->hasOne(Video::class);
    }

    public function address(){
    	return $this->hasMany(Address::class);
    }


    public function telephone(){
    	return $this->hasMany(Telephone::class);
    }


    public function location(){
    	return $this->hasMany(Location::class);
    }

    public function lab(){
        return $this->hasMany(Lab::class);
    }

    public function doctor(){
        return $this->hasMany(Doctor::class);
    }

    public function hospital(){
        return $this->hasMany(Hospital::class);
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

    public function delete()
    {
        // If the current user is who we're destroying, prevent this action and throw GeneralException
        if(auth('hospitalization')->slug() == $this->slug)
        {
            throw new GeneralException('You can\'t delete your account' );
        }

        if(parent::delete())
        {
            return true;
        }

        throw new GeneralException('deletion couldn\'t be made');
    }
}
