<?php

namespace App\Api\V1\Requests\Reservation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class Reservation extends FormRequest
{


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
            'mobile_number' => 'required|numeric|min:1|max:20',
            'telephone' => 'required|numeric|min:1|max:20',
            'slug' => 'required|not_in:0|String|min:1|max:255'

        ];
    }

      public function messages()
    {
        return [

            'name.required' => 'الرجاء ادخال الاسم',
            'mobile_number.required' => 'الرجاء ادخال رقم الموبايل',
            'telephone.required' => 'الرجاء ادخال رقم التليفون',

        ];
    }



}
