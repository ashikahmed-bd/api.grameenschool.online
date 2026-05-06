<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $this->route('category')?->id],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug,' . $this->route('category')?->id],
            'parent_id' => ['nullable', 'ulid', 'exists:categories,id'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer'],
            'show_on_homepage' => ['nullable', 'boolean'],
            'overview' => ['nullable', 'string'],
            'icon' => ['nullable', 'image', 'max:2048'],
        ];
    }


    protected function prepareForValidation(): void
    {
        $this->merge([
            'show_on_homepage' => filter_var($this->show_on_homepage, FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
        ]);
    }
}
