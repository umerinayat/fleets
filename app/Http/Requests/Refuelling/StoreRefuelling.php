<?php

namespace App\Http\Requests\Refuelling;

use Illuminate\Foundation\Http\FormRequest;

class StoreRefuelling extends FormRequest
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
            'fleet_id' => 'integer|required',
            'machine_hours' => 'numeric|required',
            'fuel_added' => 'numeric|required',
            'location' => 'string|required',
            'date' => 'date',
        ];
    }
}
