<?php

namespace App\Http\Requests\Book;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
        $book=$this->route('book');
        $id=is_object($book) ? $book->id : $book; 
     return [
            'name' => 'sometimes|string|max:255|unique:books,name,'.$id ,
            
            'description' => 'sometimes|string',
            'cost' => 'sometimes|numeric|min:0',
            'image' => 'sometimes|image|mimes:jpg,jpeg,png',
            'status' => 'sometimes|boolean',
            'category_id' => 'sometimes|exists:categories,id',
        ];
    }
}
