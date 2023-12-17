<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreMovieRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'synopsis' => ['required', 'string'],
            'duration_minutes' => ['required', 'integer'],
            'release_date' => ['required', 'date'],
            'genre' => ['required', 'string'],
            'language' => ['required', 'string'],
            'rating' => ['required', 'decimal:0,1', 'between:1,5'],
            'image' => ['required', 'image'],
            'availability' => ['required', 'boolean'],
        ];
    }
}
