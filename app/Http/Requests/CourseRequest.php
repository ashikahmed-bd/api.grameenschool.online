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
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'overview' => 'required|string',
            'description' => 'nullable|string',
            'level' => 'required|string',
            'duration' => 'required|integer|min:1',
            'is_feature' => 'required|boolean',
            'price'   => 'required|numeric|min:0',
            'learnings' => 'nullable|array',
            'learnings.*' => 'string|max:255',

            'requirements' => 'nullable|array',
            'requirements.*' => 'string|max:255',

            'published_at' => 'nullable|date',
            'video_id' => 'nullable|string',
            'provider' => 'nullable|string',
            'status' => ['required', Rule::enum(CourseStatus::class)],

            'instructors' => 'required|array',

            'category_id' => 'required|ulid|exists:categories,id',
            'subcategory_id' => 'nullable|ulid|exists:categories,id',
            'bundle_id' => 'nullable|ulid|exists:bundles,id',
        ];
    }
}
