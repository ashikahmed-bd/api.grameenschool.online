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
            'code'       => ['required', 'string', 'max:50', Rule::unique('coupons', 'code')->ignore($this->coupon)],
            'type'       => 'required|in:percentage,fixed',
            'value'      => 'required|numeric|min:0',
            'max_uses'   => 'nullable|integer|min:1',
            'expires_at' => ['nullable', 'date', 'date_format:Y-m-d H:i:s'],
            'active'     => 'boolean',
            'course_id'  => 'nullable|exists:courses,id',
        ];
    }
}
