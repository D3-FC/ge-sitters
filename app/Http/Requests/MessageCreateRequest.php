<?php

namespace App\Http\Requests;

use App\Enums\R;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MessageCreateRequest extends FormRequest
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
            'content' => R::build([R::REQUIRED, R::TEXT]),
            'to_user.id' => [
                'required',
                'exists:users,id',
                Rule::notIn([\Auth::id()]),
            ],
        ];
    }
}
