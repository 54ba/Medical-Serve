<?php

namespace App\Http\Requests\Reservation;

use App\Http\Requests\Reservation\Reservation;
use Illuminate\Http\Response;

class Doctor extends Reservation
{

    public function messages()
    {
        return parent::messages() + [
            'slug.required' => 'الرجاء اختيار  الدكتور',
        ];
    }
     public function store()
    {
        $doctor = new \App\Reservation\Doctor();

        $doctor->name = $this->name;
        $doctor->mobile_number = $this->mobile_number;
        $doctor->telephone = $this->age;

        $hospitalization = \App\Hospitalization\Doctor::where('slug',$this->slug)->first();
        $doctor->hospitalization_id = $hospitalization->id;

       

        if ($doctor->save())
        {
            $response->status = $response::HTTP_OK;
            return Response::json($response);
        }

        $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
        
        return Response::json($response);

    }

}
