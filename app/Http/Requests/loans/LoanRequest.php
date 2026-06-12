<?php

namespace App\Http\Requests\loans;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class LoanRequest extends FormRequest
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
            // 'user_id'=>"required|exists:users,id",
            // 'loans_at'=>'required',
            'book_id'=>'required|exists:books,id',
            'due_date'=>'required|date|after:today',
        ];
    }
    public function messages()
    {
        return [
            'book_id.required'=>"You must select the book you want",
            'book_id.exists'=>' Sorry , The selected book does not exist',
            'due_date.required'=>'You must enter Date of retrieval',
            'due_date'=>'retrieval date must be after day '
        ];
    }
}
