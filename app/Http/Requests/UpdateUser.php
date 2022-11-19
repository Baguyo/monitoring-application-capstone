<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
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
            'avatar' => 'image|mimes:jpg,jpeg,gif,png,svg|max:3000',
            'name' => 'bail|required|min:5',
            'email' => "bail|required|email|unique:users,email,".Auth()->id(),
            'password' => 'confirmed',
            'guardian'=> 'bail|required|min:5',
            'address' => 'bail|required|min:4',
            'contact_number'=>'bail|required|integer',
        ];
    }
}
