<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->route('user')->id ?? null;
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => [
                'sometimes',
                'required',
                'numeric',
                Rule::unique('users', 'phone')->ignore($userId)
            ],
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($userId)
            ],
            'username' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($userId)
            ],
            'password' => ['nullable', 'string', 'min:6', 'max:255'],
            'role' => ['required', Rule::enum(UserRole::class)],
            'avatar' => ['nullable', 'image', 'mimes:png,jpg,webp', 'max:2048'],
            'active' => ['nullable', 'in:true,false,1,0'],
        ];
    }

    /**
     * Customize error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please provide a name.',
            'email.required' => 'Email address is required.',
            'email.unique' => 'This email is already in use.',
            'phone.unique' => 'This phone number is already registered.',
            'username.unique' => 'This username is already taken.',
            'role.required' => 'Please select a valid user role.',
            'active.in' => 'The active field must be true or false.',
        ];
    }

    /**
     * Modify input before validation.
     */
    protected function prepareForValidation(): void
    {
        // Automatically cast 'active' values like "1"/"0" to true/false
        $this->merge([
            'active' => filter_var($this->active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);
    }
}
