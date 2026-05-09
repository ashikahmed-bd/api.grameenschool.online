<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'active' => filter_var($this->active, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'course_id'  => 'nullable|exists:courses,hashid',
            'owner_id'  => 'nullable|exists:users,hashid',
            'code'       => ['required', 'string', 'max:50', Rule::unique('coupons', 'code')->ignore($this->coupon)],
            'type'         => ['required', 'in:percent,fixed'],
            'discount'     => ['required', 'numeric', 'min:0'],
            'commission'   => ['nullable', 'numeric', 'min:0'],
            'usage_limit'  => ['required', 'integer', 'min:1'],
            'starts_at'    => ['nullable', 'date'],
            'expires_at'   => ['nullable', 'date', 'after_or_equal:starts_at'],
            'active'       => ['boolean'],
        ];
    }
}
