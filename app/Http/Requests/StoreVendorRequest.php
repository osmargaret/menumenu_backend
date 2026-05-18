<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name'               => 'required|string|max:255',
            'tagline'            => 'nullable|string|max:255',
            'description'        => 'nullable|string',
            'phone'              => 'nullable|string|max:20',
            'address'            => 'nullable|string',
            'state_id'           => 'nullable|exists:states,id',
            'city_id'            => 'nullable|exists:cities,id',
            'is_open'            => 'boolean',
            'open_time'          => 'nullable|date_format:H:i',
            'close_time'         => 'nullable|date_format:H:i',
            'delivery_available' => 'boolean',
            'pickup_available'   => 'boolean',
            'commission_percent' => 'nullable|integer|min:0|max:100',
        ];
    }
}
