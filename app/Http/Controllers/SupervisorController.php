<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Supervisor;
use App\Http\Requests\StoreSupervisorRequest;
use App\Http\Requests\UpdateSupervisorRequest;
use App\Http\Resources\SupervisorResource;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class SupervisorController extends Controller
{
    /**
     * Store a newly created supervisor in storage.
     */
    public function store(StoreSupervisorRequest $request, FileUploadService $fileService): SupervisorResource
    {
        $supervisor = Supervisor::query()->create($request->validated());
        if ($request->hasFile('image')) {
            $fileService->uploadAndAttach(
                $request->file('image'),
                $supervisor,
                'image',
                'Supervisors',
                'public_id_for_image',
                'image'

            );

        }

        return new SupervisorResource($supervisor);
    }

    /**
     * Display the specified supervisor.
     */
    public function show(Supervisor $supervisor): SupervisorResource
    {
        return new SupervisorResource($supervisor);
    }

    /**
     * Update the specified supervisor in storage.
     */
    public function update(UpdateSupervisorRequest $request, Supervisor $supervisor, FileUploadService $fileService): SupervisorResource
    {


        $supervisor->update($request->validated());

        return new SupervisorResource($supervisor);
    }

    /**
     * Remove the specified supervisor from storage.
     */
    public function destroy(Supervisor $supervisor): Response
    {
        if (!empty($student->public_id_for_image)) {
            cloudinary()->uploadApi()->destroy($student->public_id_for_image);
        }
        $supervisor->delete();

        return response()->noContent();
    }

    /**
     * Display a listing of supervisors.
     */
    public function index(): AnonymousResourceCollection
    {
        return SupervisorResource::collection(Supervisor::all());
    }


    public function updateImage(Request $request, Supervisor $supervisor, FileUploadService $fileService): Response
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg',
        ]);


        if ($request->hasFile('image')) {
            $fileService->uploadAndAttach(
                $request->file('image'),
                $supervisor,
                'image',
                'Supervisors',
                'public_id_for_image',
                'image'
            );

        }


        return response()->noContent(204,[
            'message' => 'Image updated successfully',
        ]);
    }
}
