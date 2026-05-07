<?php

namespace App\Http\Requests;

use App\Enums\CourseStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'learnings' => is_array($this->learnings)
                ? $this->learnings
                : (is_string($this->learnings) ? json_decode($this->learnings, true) : []),
            'requirements' => is_array($this->requirements)
                ? $this->requirements
                : (is_string($this->requirements) ? json_decode($this->requirements, true) : []),

            'features' => is_array($this->features)
                ? $this->features
                : (is_string($this->features) ? json_decode($this->features, true) : []),
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
            'category_id' => 'required|exists:categories,hashid',
            'subcategory_id' => 'nullable|exists:categories,hashid',
            'collection_id' => 'nullable|exists:collections,hashid',
            'grade_id' => 'nullable|exists:grades,hashid',
            'batch_id' => 'nullable|exists:batches,hashid',

            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'overview' => 'required|string',
            'description' => 'nullable|string',

            'meta_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keywords' => 'required|string',
            'canonical_url' => 'required|string',

            'base_price' => 'required|numeric|min:0',
            'price' => 'nullable|numeric|min:0',
            'access_days' => 'nullable|integer|min:1',
            'level' => 'required|string',
            'is_feature' => 'required|boolean',

            'learnings' => 'nullable|array',
            'learnings.*' => 'string|max:255',

            'requirements' => 'nullable|array',
            'requirements.*' => 'string|max:255',

            'includes' => 'nullable|array',
            'includes.*' => 'string|max:255',

            'status' => ['required', Rule::enum(CourseStatus::class)],
        ];
    }
}
