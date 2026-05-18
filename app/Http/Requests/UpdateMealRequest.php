<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name'       => 'sometimes|required|string|max:255',
            'description'=> 'nullable|string',
            'price'      => 'nullable|integer|min:0',
            'category'   => 'nullable|string|max:100',
            'prep_time'  => 'nullable|integer|min:1',
            'image_path' => 'nullable|string|max:500',
            'available'  => 'boolean',
        ];
    }
}
