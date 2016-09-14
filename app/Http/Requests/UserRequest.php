<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
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
            'txtName' => 'required|max:255',
            'body' => 'required',
        ];
    }
     public function messages(){
        \Session::flash('message','<p class="alert alert-danger"><em>Failed!</em></p>');
        $message = [
            'txtName.*' => 'required', 
        ];
        return $message;
    }
}
