<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
          return [
            'name'  => 'required|string|max:50',
            'email' => 'required|email|unique:clients,email',
            'phone'  => 'required|string|min:10|max:15',
            'country_id' => 'required|exists:countries,id',
            'service_id' => 'required|exists:service_types,id',
            'domain_name'  => 'required|string|max:255',
            'start_date' => 'required|date',
            'price' => 'required|numeric|min:1',
            'duration' => 'required|in:1,2,3,4,5',
            'website_type_id' => 'required|exists:website_types,id',
            'platform_id' => 'required|exists:platforms,id',
            'category_id' => 'required|exists:categories,id',
    ];
    }
}
