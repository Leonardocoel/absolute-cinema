<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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

        $user = $this->route('usuario');

        return [
            'name' => ['required', 'string', Rule::unique('users')->ignore($user)],
            'cpf' => ['required', 'string',  'size:14',  Rule::unique('users')->ignore($user)],
        ];
    }
}
