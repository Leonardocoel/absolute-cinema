<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreCinemaRequest extends FormRequest
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
            'name' => ['required', 'string', 'unique:cinemas'],
            'cnpj' => ['required', 'string',  'size:18', 'unique:cinemas'],
            'email' => ['required', 'string', 'email', 'unique:cinemas'],
            'state' => ['required', 'string', 'size:2'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'phone' => ['string', 'unique:cinemas']
        ];
    }
}
