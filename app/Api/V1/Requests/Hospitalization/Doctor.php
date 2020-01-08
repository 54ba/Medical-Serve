<?php

namespace App\Api\V1\Requests\Hospitalization;

use Illuminate\Http\Response;
use App\Information;
use App\Models\Information\Specialization;

class Doctor extends Hospitalization
{
     public function rules()
    {

        return parent::rules() +
        [
           'specialization'=> 'required|array|min:1',
           'specialization.*' => 'distinct|min:1|max:500',
        ];
    }

    public function messages()
    {
        return parent::messages() +
        [
            'specialization.required' => 'الرجاء ادخال التخصص',
        ];
    }

     public function store()
    {

        parent::store();

        $doctor = new \App\Models\Hospitalization\Doctor();
        $hospitalization = new \App\Models\Hospitalization\Hospitalization();

        $hospitalization->name = $this->name;
        $hospitalization->email = $this->email;
        $hospitalization->password = bcrypt($this->password);

          if(count($specializations = $this->specialization))
        {

            foreach ($specializations as $key => $specialization_input )
            {
                $this->objects['specialization'][$key] = new Specialization();
                $this->objects['specialization'][$key]->specialization = $specialization_input;
            }
        }

        $hospitalization->slug = str_slug($hospitalization->name . $specializations[0]);
        while(\App\Models\Hospitalization\Hospitalization::where('slug',$hospitalization->slug)->first())
        {
            $hospitalization->slug .= '-' . str_random(2);
        }
        $response = new Response();


        if ($hospitalization->save() && $hospitalization->doctor()->save($doctor))
        {
            $hospitalization->refresh();

                try
            {
                foreach ($this->objects as $object)
                {

                    if(is_array($object) && count($object))
                    {
                        //object is array of objects

                        array_map(function($information) use ($hospitalization)
                        {
                            $information->hospitalization_id = $hospitalization->id;
                            $information->save();
                        }, $object);

                    }elseif(null != $object && !empty($object))
                    {
                        $object->hospitalization_id = $hospitalization->id;
                        $object->save();
                    }
                }
            }catch(Exception $e)
            {


                $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
                return Response::json($response);
            }

                    $response->status = $response::HTTP_OK;
                    return response()->json($response);
        }

        $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
        return Response::json($response);

    }

      public function edit($slug = false)
    {

        if($slug == false )
        {
            return abort(404);
        }

        parent::edit();

        $doctor = \App\Models\Hospitalization\Doctor::where('slug',$slug)->firstOrFail();

        $doctor->hospitalization->name = $this->name;
        $doctor->hospitalization->email = $this->email;
        $doctor->hospitalization->password = bcrypt($this->password); //needs edit
        $specializations_input = $this->specialization;
          if(is_array($specializations_input) && count($specializations_input))
        {

            foreach ($specializations_input as $key => $specialization_input )
            {
                if($specialization_input != $doctor->specialization[$key]->specialization)
                {
                    $this->objects['specialization'][$key] = new Specialization();
                    $this->objects['specialization'][$key]->specialization = $specialization_input;
                }

            }
        }
        if(is_array($this->objects['specialization']) && count($this->objects['specialization']))
        {
            $doctor->hospitalization->slug = str_slug($doctor->hospitalization->name .  $this->objects['specialization'][0]);
            while(\App\Models\Hospitalization\Hospitalization::where('slug',$doctor->hospitalization->slug)->first())
            {
                $doctor->hospitalization->slug .= '-' . str_random(2);
            }
        }

        $response = new Response();

        if ($doctor->hospitalization->save() && $doctor->save())
        {
            try
            {
                $doctor->hospitalization->refresh();

                 foreach ($this->objects as $key=>$object)
                {

                    if(is_array($object) && count($object))
                    {
                        //object is array of objects

                        array_map(function($information) use ($doctor)
                        {
                            $information->hospitalization_id = $doctor->hospitalization->id;;
                            $information->save();

                        }, $object);
                    }elseif(null != $object && !empty($object))
                    {
                            $object->hospitalization_id = $doctor->hospitalization->id;
                            $object->save();
                    }
                }
            }catch(Exception $e)
            {
                $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
                return Response::json($response);
            }


            $response->status = $response::HTTP_OK;
            return Response::json($response);
        }

        $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
        return Response::json($response);

    }
}
