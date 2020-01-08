<?php

namespace App\Models\Hospitalization;
use App\Hospitalization\App;
use App\Models\Hospitalization\Hospitalization;
use App\Models\Information\Specialization;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UUID;

class Doctor extends Model
{

    use SoftDeletes;
    use UUId;

	protected $table = 'doctor_hospitalizations';

    public $incrementing = false;

    protected $with =['specialization','hospitalization'];

    protected $casts = [
        'id' =>'string',
        'hospitalization_id' =>'string'
    ];

    public function specialization(){
    	return $this->hasMany(Specialization::class);
    }

    public function hospitalization()
    {
    	return $this->belongsTo(Hospitalization::class);
    }

    public function reservations(){
    	return $this->hasMany(App\Reservation\Doctor::class,'doctor_id');
    }

    public function delete()
    {
        $this->hospitalization()->delete();
    }



}
