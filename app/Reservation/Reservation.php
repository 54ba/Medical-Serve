<?php

namespace App\Reservation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class Reservation extends Model
{

    use SoftDeletes;
   	use UUId;


	$fillable = 
    [
    	'name',
    	'mobile_number',
    	'telephone',
    	'age'
    ];


}
