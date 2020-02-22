<?php

namespace App\Http\Requests;

use App\Enums\R;
use App\Worker;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class WorkerCreateUpdateRequest
 *
 * @package App\Http\Requests
 * @mixin Worker
 */
class WorkerCreateUpdateRequest extends FormRequest
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
            'min_child_age'=>'integer|nullable|min:0|max:50',
            'max_child_age'=>'integer|nullable|gte:min_child_age|max:50',
            'description'=>R::TEXT,
            'animal_relationship'=>R::TEXT,
            'meeting_price'=>R::MONEY_SIMPLE,
            'coords_x'=>R::COORDS,
            'coords_y'=>R::COORDS,
            'has_card_payment'=>R::BOOLEAN,
            'sits_special_children'=>R::BOOLEAN,
            'has_training'=>R::BOOLEAN,
            'can_overwork'=>R::BOOLEAN,
            'birthday'=>'date|before:now',
        ];
    }
}
