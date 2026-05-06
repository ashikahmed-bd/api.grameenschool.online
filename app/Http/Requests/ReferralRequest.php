<?php

namespace App\Http\Requests;

use App\Models\Referral;
use Illuminate\Foundation\Http\FormRequest;

class ReferralRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id|unique:referrals,user_id',
            'code' => 'required|string|unique:referrals,code',
            'commission' => 'nullable|integer|min:0|max:100',
            'discount' => 'nullable|integer|min:0|max:100',
            'status' => 'nullable|in:pending,approved,rejected',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'Selected user does not exist.',

            'code.required' => 'Referral code is required.',
            'code.string' => 'Referral code must be a valid string.',
            'code.unique' => 'This referral code is already taken.',
            'code.max' => 'Referral code may not be greater than 50 characters.',

            'commission.integer' => 'Commission must be a number.',
            'commission.min' => 'Commission cannot be less than 0.',
            'commission.max' => 'Commission cannot exceed 100.',

            'discount.integer' => 'Discount must be a number.',
            'discount.min' => 'Discount cannot be less than 0.',
            'discount.max' => 'Discount cannot exceed 100.',

            'status.in' => 'Status must be one of: pending, approved, or rejected.',
        ];
    }
}
