<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'username' => ['required',],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'address1' => ['required'],
            'address2' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],
            'postcode' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email,' . auth()->id()],
        ];
    }
}
