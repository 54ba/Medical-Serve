<?php

namespace App\Api\V1\Requests\Hospitalization;

use App\Information;
use Illuminate\Http\Response;

class Lab extends Hospitalization
{

     public function store()
    {
        parent::store();

        $lab = new \App\Models\Hospitalization\Lab();
        $hospitalization = new \App\Models\Hospitalization\Hospitalization();

        $hospitalization->email = $this->email;
        $hospitalization->password = bcrypt($this->password);

        if( $lab->hospitalization->name != $this->name)
        {
            $hospitalization->name = $this->name;
            $lab->hospitalization->slug = str_slug($lab->name);
            while(\App\Models\Hospitalization\Hospitalization::where('slug',$hospital->hospitalization->slug)->first())
            {
                $hospital->hospitalization->slug .= '-' . str_random(2);
            }
        }

        $response = new Response();

        if($hospitalization->save() && $hospitalization->lab()->save($lab))
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



      public function edit($slug =false)
    {

        if($slug == false )
        {
            return abort(404);
        }

        parent::edit();

        $lab = \App\Models\Hospitalization\Lab::where('slug',$slug)->firstOrFail();
        $lab->hospitalization->name = $this->name;
        $lab->hospitalization->email = $this->email;
        $lab->hospitalization->password = bcrypt($this->password); //needs edit

        $lab->hospitalization->slug = str_slug($lab->hospitalization->name);
        while(\App\Models\Hospitalization\Hospitalization::where('slug',$lab->hospitalization->slug)->first())
        {
            $lab->hospitalization->slug .= '-' . str_random(2);
        }
        $response = new Response();

        if ($lab->hospitalization->save() && $lab->save())
        {
            try
            {
                $lab->hospitalization->refresh();

                 foreach ($this->objects as $object)
                {

                    if(is_array($object) && count($object))
                    {
                        //object is array of objects

                        array_map(function($information) use ($lab)
                        {
                            $information->hospitalization_id = $lab->hospitalization->id;;
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
            return Response::json($response);
        }

        $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
        return Response::json($response);

    }

}
