<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'password' => ['required', 'min:4', 'max:16'],
            'email' => ['required', 'email', 'max:255'],
        ];

        if ($this->method() == 'PUT'){
            $rules['password'] = ['nullable', 'min:4', 'max:16'];
        }

        return $rules;
    }
}
