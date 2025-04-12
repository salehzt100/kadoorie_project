<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'abstract' => 'nullable|string',
            'faculty_department_id' => 'required|exists:faculty_departments,id',
            'category_id' => 'required|exists:categories,id',
            'visibility' => 'sometimes|boolean',
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',

            // Accept PDF, Word, and other document formats
            'thesis' => 'nullable|file',
            'poster' => 'nullable|file',
//            'thesis' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt',
//            'poster' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt',
            'thesis_name' => 'nullable|string|max:255',
            'poster_name' => 'nullable|string|max:255',

            // Ensure students and supervisors are valid arrays of IDs
            'students' => 'required|array|min:1',
            'students.*' => 'exists:students,id',
            'supervisors' => 'required|array|min:1',
            'supervisors.*' => 'exists:supervisors,id',
        ];
    }
}
