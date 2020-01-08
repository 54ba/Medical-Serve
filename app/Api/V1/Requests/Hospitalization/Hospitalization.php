<?php

namespace App\Api\V1\Requests\Hospitalization;

use Faker\Provider\Image;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use App\Models\Information\Picture;
use App\Models\Information\Address;
use App\Models\Information\Location;
use App\Models\Information\Telephone;
use App\Models\Information\Video;


class Hospitalization extends FormRequest
{

    protected $objects = [
        'picutre' ,
        'video',
        'telephones'=> [],
        'locations' => [],
        'addresses'=> []

    ];


     /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return true;
    }

     /**
     * The data to be validated should be processed as JSON.
     * @return mixed
     */
    public function validationData()
    {
        return $this->json()->all();
    }

     protected function failedValidation(Validator $validator)
    {
        $result = ['status' => 'error' ,'data' => $validator->errors()->all()];

        throw new HttpResponseException(response()->json($result , 200));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|String|min:1|max:191',
            'password' => 'required|String|confirmed|min:6|max:255',
            'password_confirmation'=> 'required|min:6',
            'picture' => 'image|mimes:jpeg,png,jpg|max:2048',
            'video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi',
            'address' => 'array|min:1',
            'address.*' =>'string|distinct|min:1|max:500',
            'telephone' => 'array|min:1',
            'telephone.*' =>'distinct|min:1|max:500',
            'longitude' => 'distinct|min:1|max:500',
            'longitude.*' => 'numeric|min:1|max:191',
            'latitude' => 'distinct|min:1|max:500',
            'latitude.*' => 'numeric|min:1|max:191',


        ];
    }

      public function messages()
    {
        return [

            'name.required' => 'الرجاء ادخال الاسم',
            'email.required' => 'الرجاء ادخال البريد الالكتروني',
            'password.required' => 'الجراء ادخال كلمة المرور',
            'password_confirmation.required' => 'الرجاء ادخال تأكيد كلمة المرور',
            'telephone.required' => 'الرجاء ادخال رقم التليفون',


        ];
    }


    public function store()
    {


        if($this->has('picture'))
        {
            // TODO::upload picture
            $this->objects['picture'] = new Picutre();
            $this->objects['picture']->source = $this->picture->hashName();
            Image::make(storage_path($this->objects['picture']->upload_path .$this->objects['picture']->source ))
                ->resize(750, 579)
                ->encode('png', 100)
                ->save(storage_path($this->objects['picture']->upload_path .$this->objects['picture']->source ));

        }

        if($this->has('video'))
        {
            // TODO::upload video
            $this->objects['video'] = new Video();
            $this->objects['video']->source = $this->video;

        }

        if(is_array($this->longitude) && is_array($this->latitude))
        {
            if(($longitude_length = count($longitudes = $this->longitude))&&( $latitude_length = count($latitudes = $this->latitude)) && ($longitude_length == $latitude_length ))
            {
                foreach ($longitudes as  $key => $longitude_input )
                {
                    $this->objects['locations'][$key] = new Location();
                    $this->objects['locations'][$key]->longitude = $longitude_input;
                    $this->objects['locations'][$key]->latitude = $latitudes[$key];

                }

            }
        }


        if(is_array($this->telephone))
        {

            if(count($telephones = $this->telephone))
            {
                foreach ($telephones as $key => $telephone_input )
                {
                    $this->objects['telephones'][$key] = new Telephone();
                    $this->objects['telephones'][$key]->telephone = $telephone_input;
                }
            }

        }

        if(is_array($this->address))
        {
            if(count($addresses = $this->address))
            {
                foreach ($addresses as $key => $address_input )
                {
                    $this->objects['addresses'][$key] = new Address();
                    $this->objects['addresses'][$key]->address = $address_input;
                }
            }
        }

    }

    public function edit($slug =false)
    {

        if($this->has('picture'))
        {
            // TODO::upload picture

            $this->objects['picture'] = new Picutre();
            $this->objects['picture']->source = $this->picture->hashName();

        }

        if($this->has('video'))
        {
            // TODO::upload video
            $this->objects['video'] = new Video();
            $this->objects['video']->source = $this->video->hashName();

        }

        if(is_array($this->longitude) && is_array($this->latitude))
        {

            if(($longitude_length = count($longitudes = $this->longitude)) && ($latitude_length = count($latitudes = $this->latitude)) && ($longitude_length == $latitude_length ))
            {
                foreach ($longitudes as  $key => $longitude_input ) {
                    $this->objects['locations'][$key] = new Location();
                    $this->objects['locations'][$key]->longitude = $longitude_input;
                    $this->objects['locations'][$key]->latitude = $latitudes[$key];

                }

            }
        }


        if(is_array($this->telephone))
        {


            if(count($telephones = $this->telephone))
            {
                foreach ($telephones as $key => $telephone_input ) {
                    $this->objects['telephones'][$key] = new Telephone();
                    $this->objects['telephones'][$key]->telephone = $telephone_input;
                }
            }

        }


        if(is_array($this->address))
        {

            if(count($addresses = $this->address))
            {
                foreach ($addresses as $key => $address_input ) {
                    $this->objects['addresses'][$key] = new Address();
                    $this->objects['addresses'][$key]->address = $address_input;
                }
            }
        }

    }
}
