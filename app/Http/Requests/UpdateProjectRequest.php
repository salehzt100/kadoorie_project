<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'abstract' => 'nullable|string',
            'faculty_department_id' => 'sometimes|required|exists:faculty_departments,id',
            'category_id' => 'sometimes|required|exists:categories,id',
            'visibility' => 'sometimes|boolean',

            'thesis_name' => 'nullable|string|max:255',
            'poster_name' => 'nullable|string|max:255',


            // Ensure students and supervisors are valid arrays of IDs
            'students' => 'sometimes|required|array|min:1',
            'students.*' => 'exists:students,id',
            'supervisors' => 'sometimes|required|array|min:1',
            'supervisors.*' => 'exists:supervisors,id',
        ];
    }
}
