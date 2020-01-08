<?php

namespace App\Models\Reservation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class Reservation extends Model
{

    use SoftDeletes;
   	use UUId;


	protected $fillable =
    [
    	'name',
    	'mobile_number',
    	'telephone',
    	'age'
    ];


    public function delete()
    {
        if(parent::delete())
        {
            return true;
        }

        throw new GeneralException('deletion couldn\'t be made');
    }
}
