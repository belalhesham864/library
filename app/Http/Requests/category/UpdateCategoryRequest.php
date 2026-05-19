<?php

namespace App\Http\Requests\category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
 $id = $this->route('category');
    // dd($this->route()->parameters());
      return [
        'title' => 'sometimes|nullable|between:3,20|string|unique:categories,title,'.$id,
        'description' => 'sometimes|nullable|string|between:20,100',
    ];
    }
}
