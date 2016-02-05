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
            'timeEstimated' =>  ['required', 'between:0,800',
             'regex:/^\d{1,3}[.]\d{1}$|^[.]\d{1}$|^\d{1,3}$/'],
                
            
            'timeSpent' =>  [ 
                'required', 'between:0,800',
                'regex:/^\d{1,3}[.]\d{1}$|^[.]\d{1}$|^\d{1,3}$/', 
                ],

            'stressLevel' => 'required|integer|between:0,10',
            'comments' => 'max:300',
        ];
    }
}
