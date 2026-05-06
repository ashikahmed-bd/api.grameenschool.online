<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AcademicRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'grade_id' => 'required|exists:grades,id',
            'batch_id' => 'required|exists:batches,id',
            'group_id' => 'nullable|exists:groups,id',
        ];
    }

    public function messages()
    {
        return [
            'grade_id.required' => 'ক্লাস অবশ্যই দিতে হবে',
            'batch_id.required' => 'Batch অবশ্যই দিতে হবে',
            'grade_id.exists' => 'সঠিক Grade নির্বাচন করুন',
            'batch_id.exists' => 'সঠিক Batch নির্বাচন করুন',
            'group_id.exists' => 'সঠিক Group নির্বাচন করুন',
        ];
    }
}
