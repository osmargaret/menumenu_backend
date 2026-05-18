<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name'               => 'sometimes|required|string|max:255',
            'tagline'            => 'sometimes|nullable|string|max:255',
            'description'        => 'sometimes|nullable|string',
            'phone'              => 'sometimes|nullable|string|max:20',
            'address'            => 'sometimes|nullable|string',
            'state_id'           => 'sometimes|nullable|exists:states,id',
            'city_id'            => 'sometimes|nullable|exists:cities,id',
            'is_open'            => 'sometimes|boolean',
            'open_time'          => 'sometimes|nullable|date_format:H:i',
            'close_time'         => 'sometimes|nullable|date_format:H:i',
            'delivery_available' => 'sometimes|boolean',
            'pickup_available'   => 'sometimes|boolean',
        ];
    }
}
