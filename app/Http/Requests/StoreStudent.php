<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudent extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'image' => "nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2000",
            'name' => 'bail|required|regex:/(^[A-Za-z ]+$)+/|min:3',
            'email' => 'bail|required|min:3|email|unique:users',
            'password'=> 'bail|required|confirmed|min:6',
            'student_number' => 'bail|required|min:3|unique:students',
            // 'guardian'=> 'bail|required|min:5|unique:students',
            // 'address' => 'bail|required|min:4',
            'contact_number'=>'bail|required|integer',
            // 'strand' => 'required',
            // 'level'=> 'required',
            // 'section'=> 'required'
        ];
    }
}
