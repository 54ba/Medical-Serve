<?php

namespace App\Models\Auth\User;

use App\Models\Auth\User\Traits\Ables\Rolable;
use App\Models\Auth\User\Traits\Attributes\UserAttributes;
use App\Models\Auth\User\Traits\Relations\UserRelations;
use App\Models\Auth\User\Traits\Scopes\UserScopes;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Notifications\User\ResetPasswordNotification as UserResetPasswordNotification;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable implements JWTSubject
{
    use Rolable,
        UserAttributes,
        UserScopes,
        UserRelations,
        Notifiable,
        SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

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

    public function delete($id)
    {
        // If the current user is who we're destroying, prevent this action and throw GeneralException
        if(auth()->id() == $id)
        {
            throw new GeneralException('You can\'t delete your account' );
        }

        $user = $this->find($id);

        if($user->delete())
        {
            return true;
        }

        throw new GeneralException('deletion couldn\'t be made');
    }
}
