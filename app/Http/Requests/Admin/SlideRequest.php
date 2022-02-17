<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
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
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'title' => ['required', 'max:255'],
                    'url' => ['required', 'max:255'],
                    'body' => ['required', 'max:255'],
                    'cover' => ['required','mimes:jpg,jpeg,png,gif', 'max:3000']
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => ['required', 'max:255'],
                    'url' => ['required', 'max:255'],
                    'body' => ['required', 'max:255'],
                    'cover' => ['mimes:jpg,jpeg,png,gif', 'max:3000']
                ];
            }
            default: break;
        }
    }
}
