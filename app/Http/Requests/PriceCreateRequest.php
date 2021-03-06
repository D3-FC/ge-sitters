<?php

namespace App\Http\Requests;

use App\Enums\R;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PriceCreateRequest extends FormRequest
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
            'children_count' => R::CHILDREN_COUNT."|".
                R::REQUIRED."|".
                Rule::unique('prices')
                    ->where('worker_id', \Auth::user()->worker->id)
                    ->whereNull('deleted_at'),
            'amount_per_hour' => R::MONEY_SIMPLE."|".R::REQUIRED,
            'over_time_amount_per_hour' => R::MONEY_SIMPLE,
        ];
    }
}
