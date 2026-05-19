<?php

namespace App\Http\Requests\loans;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

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
            'user_id'=>"required|exists:users,id",
            'book_id'=>'required|exists:books,id',
            'loans_at'=>'required|date',
            'due_date'=>'required|date|after:loans_at',
        ];
    }
}
