<?php

namespace App\Http\Requests\loans;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLoanRequest extends FormRequest
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
        return[

            'user_id'=>"sometimes|exists:users,id",
            'book_id'=>'sometimes|exists:books,id',
            'loans_at'=>'sometimes|date',
            'due_date'=>'sometimes|date|after:loans_at',
            ];
            }
}
