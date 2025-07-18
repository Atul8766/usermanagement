<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BulkUserStoreRequest extends FormRequest
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
            'users' => ['required', 'array', 'min:1'],
            'users.*.name' => ['required', 'string', 'max:255'],
            'users.*.email' => ['required', 'email', 'unique:users,email'],
            'users.*.password' => ['required', 'string', 'min:6'],
            'users.*.role' => ['required', 'in:user,admin'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation Failed',
            'data' => $validator->errors()
        ], 422));
    }
}
