<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StudentActivityRequest extends Request
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'timeEstimated' =>  'required|numeric|between:0,800|regex:/^\d{0,3}.{0,1}5{0,1}$/',
            
            'timeSpent' =>   
                'required|numeric|between:0,800|regex:/^\d{0,3}.{0,1}5{0,1}$/',
               

            'stressLevel' => 'required|integer|between:0,10',
            'comments' => 'max:300',
        ];
    }
}
