<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCinemaRequest extends FormRequest
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

        $user = $this->route('cinema');

        return [
            'name' => ['required', 'string', Rule::unique('cinemas')->ignore($user)],
            'cnpj' => ['required', 'string',  'size:18', Rule::unique('cinemas')->ignore($user)],
            'email' => ['required', 'string', 'email', Rule::unique('cinemas')->ignore($user)],
            'state' => ['required', 'string', 'size:2'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'phone' => ['string', Rule::unique('cinemas')->ignore($user)]
        ];
    }
}
