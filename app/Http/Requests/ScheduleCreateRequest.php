<?php

namespace App\Http\Requests;

use App\Enums\R;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ScheduleCreateRequest extends FormRequest
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
            'day' => R::REQUIRED."|".
                R::DAY."|".
                Rule::unique('schedules')->where('worker_id', \Auth::user()->worker->id)
                    ->whereNull('deleted_at'),
            'from' => R::TIME,
            'to' => R::TIME."|".'after:from',
        ];
    }
}
