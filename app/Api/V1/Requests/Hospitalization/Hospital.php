<?php

namespace App\Api\V1\Requests\Hospitalization;

use Illuminate\Http\Response;
use App\Information;

class Hospital extends Hospitalization
{

     public function store()
    {

        parent::store();

        $hospital = new \App\Models\Hospitalization\Hospital();
        $hospitalization = new \App\Models\Hospitalization\Hospitalization();

        $hospitalization->name = $this->name;
        $hospitalization->email = $this->email;
        $hospitalization->password = bcrypt($this->password);

        $hospitalization->slug = str_slug($hospitalization->name);

        while(\App\Models\Hospitalization\Hospitalization::where('slug',$hospitalization->slug)->first())
        {
            $hospitalization->slug .= '-' . str_random(2);
        }

        $response = new Response();

        if ($hospitalization->save() && $hospitalization->hospital()->save($hospital))
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

        $hospital = \App\Models\Hospitalization\Hospital::where('slug',$slug)->firstOrFail();

        $hospital->hospitalization->email = $this->email;
        $hospital->hospitalization->password = bcrypt($this->password); //needs edit
        if( $hospital->hospitalization->name != $this->name)
        {
            $hospital->hospitalization->name = $this->name;
            $hospital->hospitalization->slug = str_slug($hospital->name);
            while(\App\Models\Hospitalization\Hospitalization::where('slug',$hospital->hospitalization->slug)->first())
            {
                $hospital->hospitalization->slug .= '-' . str_random(2);
            }
        }
        $response = new Response();

        if ($hospital->hospitalization->save() && $hospital->save())
        {
            try
            {
                $hospital->hospitalization->refresh();

                 foreach ($this->objects as $object)
                {

                    if(is_array($object) && count($object))
                    {
                        //object is array of objects

                        array_map(function($information) use ($hospital)
                        {
                            $information->hospitalization_id = $hospital->hospitalization->id;;
                            $information->save();

                        }, $object);
                    }elseif(null != $object && !empty($object))
                    {
                        $object->hospitalization_id = $hospital->hospitalization->id;
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
