<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'vendor_id'  => 'required|exists:vendors,id',
            'name'       => 'required|string|max:255',
            'description'=> 'nullable|string',
            'price'      => 'required|integer|min:0',
            'category'   => 'nullable|string|max:100',
            'prep_time'  => 'nullable|integer|min:1',   // minutes
            'image_path' => 'nullable|string|max:500',
            'available'  => 'boolean',
        ];
    }
}
