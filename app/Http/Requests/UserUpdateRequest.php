<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'name' => 'string|min:3|max:255|required',
            'email' => [
                'email',
                'required',
                Rule::unique('users')->ignore($this->id),
            ],
            'phone' => 'string|nullable|regex:/^5\d{8}$/i',
        ];
    }
}
