<?php

namespace App\Http\Requests;

use App\Models\User;
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

        $cinema = $this->route('cinema');

        if (!$cinema) {
            $cinema = User::find(Auth::id())->load(['cinemas'])->cinemas[0];
        }

        return [
            'name' => ['required', 'string', Rule::unique('cinemas')->ignore($cinema)],
            'cnpj' => ['required', 'string',  'size:18', Rule::unique('cinemas')->ignore($cinema)],
            'email' => ['required', 'string', 'email', Rule::unique('cinemas')->ignore($cinema)],
            'state' => ['required', 'string', 'size:2'],
            'city' => ['required', 'string'],
            'address' => ['required', 'string'],
            'phone' => ['string', Rule::unique('cinemas')->ignore($cinema)]
        ];
    }
}
