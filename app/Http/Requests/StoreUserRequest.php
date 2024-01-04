<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string'],
            'name' => ['required', 'string'],
            'cpf' => ['required', 'string',  'size:14', 'unique:users'],
            'role' => ['required', 'string', Rule::in(['admin', 'end_user'])],
            'cinemaId' => ['sometimes', 'required', 'integer', 'exists:cinemas,id']
        ];
    }
}
