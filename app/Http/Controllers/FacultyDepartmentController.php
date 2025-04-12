<?php

namespace App\Http\Controllers;

use App\Models\FacultyDepartment;
use App\Http\Resources\FacultyDepartmentResource;
use App\Http\Requests\StoreFacultyDepartmentRequest;
use App\Http\Requests\UpdateFacultyDepartmentRequest;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FacultyDepartmentController extends Controller
{
    /**
     * Display a listing of the faculty departments.
     */
    public function index(): AnonymousResourceCollection
    {
        return FacultyDepartmentResource::collection(FacultyDepartment::all());
    }

    /**
     * Store a newly created faculty department in storage.
     */
    public function store(StoreFacultyDepartmentRequest $request): FacultyDepartmentResource
    {
        $validated = $request->validated();

        $facultyDepartment = FacultyDepartment::query()->create($validated);

        return new FacultyDepartmentResource($facultyDepartment);
    }

    /**
     * Display the specified faculty department.
     */
    public function show(FacultyDepartment $facultyDepartment): FacultyDepartmentResource
    {
        return new FacultyDepartmentResource($facultyDepartment);
    }

    /**
     * Update the specified faculty department in storage.
     */
    public function update(UpdateFacultyDepartmentRequest $request, FacultyDepartment $facultyDepartment): FacultyDepartmentResource
    {
        $facultyDepartment->update($request->validated());

        return new FacultyDepartmentResource($facultyDepartment);
    }

    /**
     * Remove the specified faculty department from storage.
     */
    public function destroy(FacultyDepartment $facultyDepartment): Response
    {
        $facultyDepartment->delete();

        return response()->noContent();
    }
}
