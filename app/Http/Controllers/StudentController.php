<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;


class StudentController extends Controller
{
    /**
     * Store a newly created student in storage.
     */



    public function store(StoreStudentRequest $request, FileUploadService $fileService): StudentResource
    {
        $validated = $request->validated();
        $student = Student::query()->create($validated);

        $fileService->uploadAndAttach(
            $request->file('image'),
            $student,
            'image',
            'Students',
            'public_id_for_image',
            'image'
        );

        return new StudentResource($student);
    }
    /**
     * Display the specified student.
     */
    public function show(Student $student): StudentResource
    {
        return new StudentResource($student);
    }

    /**
     * Update the specified student in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student): StudentResource
    {
        $student->update($request->validated());

        return new StudentResource($student);
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student): Response
    {
        if (!empty($student->public_id_for_image)) {
            cloudinary()->uploadApi()->destroy($student->public_id_for_image);
        }

        $student->delete();

        return response()->noContent();
    }

    /**
     * Display a listing of students.
     */
    public function index(): AnonymousResourceCollection
    {
        return StudentResource::collection(Student::all());
    }

    public function updateImage(Request $request, Student $student, FileUploadService $fileService): Response
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        if ($request->hasFile('image')) {
            $fileService->uploadAndAttach(
                $request->file('image'),
                $student,
                'image',
                'Students',
                'public_id_for_image',
                'image'

            );
        }


        return response()->noContent(204,[
            'message' => 'Image updated successfully',
        ]);
    }
}
