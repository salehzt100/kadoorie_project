<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email|max:255',
            'faculty_department_id' => 'required|exists:faculty_departments,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
//            'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime', // max in KB (50MB)

        ];
    }
}
