<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStudent extends FormRequest
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
            'name' => 'bail|required|min:3',
            // 'email' => 'bail|required|min:3|email|unique:users',
            // 'student_number' => 'bail|required|min:3|integer|unique:students,student_number,'.Auth::user()->student->id,
            'password'=> 'confirmed',
            // 'guardian'=> 'bail|required|min:5',
            // 'address' => 'bail|required|min:4',
            'contact_number'=>'bail|required|integer',
        ];
    }
}
