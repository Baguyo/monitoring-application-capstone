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
            'image' => "nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2000",
            'name' => 'bail|required|regex:/(^[A-Za-z ]+$)+/|min:3',
            'password'=> 'confirmed',
            'contact_number'=>'bail|required|integer',
        ];
    }
}
