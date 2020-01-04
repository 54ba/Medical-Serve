<?php

namespace App\Api\V1\Requests\Reservation;

use App\Api\V1\Requests\Reservation\Reservation;
use Illuminate\Http\Response;


class Sample extends Reservation
{

    public function messages()
    {
        return parent::messages() + [
            'slug.required' => 'الرجاء اختيار  المعمل',
        ];
    }


     public function store()
    {
        $sample = new \App\Reservation\Sample();

        $sample->name = $this->name;
        $sample->mobile_number = $this->mobile_number;
        $sample->telephone = $this->age;

        $hospitalization = \App\Hospitalization\Lab::where('slug',$this->slug)->first();
        $sample->hospitalization_id = $hospitalization->id;

       

        if ($sample->save())
        {
            $response->status = $response::HTTP_OK;

            return Response::json($response);
        }

        $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
        
        return Response::json($response);

    }

}
