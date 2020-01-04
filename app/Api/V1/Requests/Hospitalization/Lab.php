<?php

namespace App\Api\V1\Requests\Hospitalization;

use Illuminate\Http\Response;
use App\Information;

class Lab extends Hospitalization
{

     public function store()
    {

        parent::store();

        $lab = new \App\Hospitalization\Lab();
        $hospitalization = new \App\Hospitalization\Hospitalization();

        $hospitalization->name = $this->name;
        $hospitalization->email = $this->email;
        $hospitalization->password = bcrypt($this->password);

        $hospitalization->slug = str_slug($hospitalization->name);

         while(\App\Hospitalization\Lab::where('slug',$hospitalization->slug)->first())
        {
            $hospitalization->slug = $hospitalization->slug . '-'. str_random(2);
        }

        $response = new Response();
        
        if ($hospitalization->save())
            {
                $lab->hospitalization = $hospitalization;
                if ( $lab->save())
                {
                    try
                    {
                         foreach ($this->objects as $object) 
                        {

                            if(is_array($object) && count($object))
                            {   
                                //object is array of objects

                                array_map(function($information)
                                {
                                    $information->hospitalization_id = $hospital->id;
                                    $information->save();

                                }, $object);
                            }elseif (null != $object && !empty($object) )
                            {
                                
                            }
                        }
                    }catch(e)
                    {
                        $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
                        return Response::json($response);
                    }


                    $response->status = $response::HTTP_OK;
                    return Response::json($response);
                }
            }

        $response->status = $response::HTTP_INTERNAL_SERVER_ERROR ;
        return Response::json($response);

    }



      public function edit($slug)
    {

        parent::edit();

        $lab = \App\Hospitalization\Lab::where('slug',$slug)->firstOrFail();

        $lab->hospitalization->name = $this->name;
        $lab->hospitalization->email = $this->email;
        $lab->hospitalization->password = bcrypt($this->password); //needs edit

        $lab->hospitalization->slug = str_slug($lab->hospitalization->name);
        while(\App\Hospitalization\Hospitalization::where('slug',$lab->hospitalization->slug)->first())
        {
            $lab->hospitalization->slug = $lab->hospitalization->slug .'-'. str_random(2);
        }
        $response = new Response();

        if ($lab->hospitalization->save() && $lab->save())
        {
            try
            {
                 foreach ($this->objects as $object) 
                {

                    if(is_array($object) && count($object))
                    {   
                        //object is array of objects

                        array_map(function($information)
                        {
                            $information->hospitalization_id = $lab->id;
                            $information->save();

                        }, $object);
                    }elseif (null != $object && !empty($object) )
                    {
                        
                    }
                }
            }catch(e)
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
