<?php

namespace App\Http\Requests;

use App\Enums\R;
use Illuminate\Foundation\Http\FormRequest;

class AdvertisementCreateRequest extends FormRequest
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
            'children_count' => R::CHILDREN_COUNT,
            'price' => R::MONEY_SIMPLE,
            'description' => R::TEXT_OPTIONAL,
            'date' => 'date|after:yesterday',
            'from' => R::TIME,
            'to' => R::TIME.'|after:from',
        ];
    }
}
