<?php

namespace App\Http\Requests;

use App\Web\Station;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:3'],
            'address' => ['required', 'min:3'],
            'phone' => [
                'required', 'string', Rule::unique((new Station)->getTable())->ignore($this->route()->station ?? null)
            ],
            'number_station' => 'required|numeric',
            'email' => [
                'required', 'email', Rule::unique((new Station)->getTable())->ignore($this->route()->station ?? null)
            ],
        ];
    }
}
