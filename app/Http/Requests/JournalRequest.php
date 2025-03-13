<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JournalRequest extends FormRequest
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
            'date' => ['nullable', 'date_format:Y-m-d'],
            'highlights' => ['nullable', 'string', 'max:5000'],
            'highlights_jp' => ['nullable', 'string', 'max:5000'],
            'feelings' => ['nullable', 'string', 'max:5000'],
            'feelings_jp' => ['nullable', 'string', 'max:5000'],
            'learnings' => ['nullable', 'string', 'max:5000'],
            'learnings_jp' => ['nullable', 'string', 'max:5000'],
            'plans' => ['nullable', 'string', 'max:5000'],
            'plans_jp' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
