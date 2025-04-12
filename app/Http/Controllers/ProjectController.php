<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index(): AnonymousResourceCollection
    {
        return ProjectResource::collection(Project::with(['facultyDepartment', 'category', 'students', 'supervisors'])->get());
    }

    public function home(): AnonymousResourceCollection
    {
        return ProjectResource::collection(
            Project::with([
                'facultyDepartment',
                'category',
                'students',
                'supervisors'
            ])->where('visibility','=',true)
                ->get()
        );
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(StoreProjectRequest $request, FileUploadService $fileService): ProjectResource
    {

        $project = Project::create($request->validated());

        // Thesis upload

        if ($request->file('thesis')) {
            $fileService->uploadAndAttach(
                $request->file('thesis'),
                $project,
                'thesis',
                'Projects/Thesis',
                'public_id_for_thesis',
                'raw',
                [
                    'thesis_name' =>
                        empty($project->thesis_name )
                            ? $request->file('thesis')->getClientOriginalName()
                            : $project->thesis_name ,
                    'thesis_type' => $request->file('thesis')->getClientMimeType()
                ]
            );

        }

        // Poster upload
        if ($request->file('poster')) {
            $fileService->uploadAndAttach(
                $request->file('poster'),
                $project,
                'poster',
                'Projects/Poster',
                'public_id_for_poster',
                'raw',
                [
                    'poster_name' =>
                        empty($project->poster_name )
                            ? $request->file('poster')->getClientOriginalName()
                            : $project->poster_name ,
                    'poster_type' => $request->file('poster')->getClientMimeType()
                ]
            );

        }

        // Vedic upload (aka video?)
        if ($request->file('video')) {
            $fileService->uploadAndAttachVideo(
                $request->file('video'),
                $project,
                'video',
                'Projects/videos',
                'public_id_for_video',
            );

        }


        $project->students()->attach($request->input('students'));
        $project->supervisors()->attach($request->input('supervisors'));

        return new ProjectResource($project->load(['facultyDepartment', 'category', 'students', 'supervisors']));
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project): ProjectResource
    {
        return new ProjectResource($project->load(['facultyDepartment', 'category', 'students', 'supervisors']));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project, FileUploadService $fileService): ProjectResource
    {
        // Apply validated update first to reflect any name/type changes
        $project->update($request->validated());

        // Sync related students and supervisors
        $project->students()->sync($request->input('students'));
        $project->supervisors()->sync($request->input('supervisors'));

        // Return with relationships for frontend use
        return new ProjectResource($project->load(['facultyDepartment', 'category', 'students', 'supervisors']));
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project): Response
    {
        $project->students()->detach();
        $project->supervisors()->detach();

        if (!empty($project->public_id_for_thesis)) {
            cloudinary()->uploadApi()->destroy($project->public_id_for_thesis);
        }
        if (!empty($project->public_id_for_poster)) {
            cloudinary()->uploadApi()->destroy($project->public_id_for_poster);
        }
        if (!empty($project->public_id_for_video)) {
            cloudinary()->uploadApi()->destroy($project->public_id_for_video);
        }

        $project->delete();

        return response()->noContent();
    }



    public function updateThesis(Request $request, Project $project, FileUploadService $fileService): Response
    {

        $request->validate([
            'thesis' => 'nullable|file',

//            'thesis' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt',
        ]);

        if ($request->file('thesis')) {

            if (!empty($project->public_id_for_thesis)) {
                cloudinary()->uploadApi()->destroy($project->public_id_for_thesis);
            }
            $fileService->uploadAndAttach(
                $request->file('thesis'),
                $project,
                'thesis',
                'Projects/Thesis',
                'public_id_for_thesis',
                'raw',
                [
                    'thesis_name' => empty($project->thesis_name)
                        ? $request->file('thesis')->getClientOriginalName()
                        : $project->thesis_name,
                    'thesis_type' => $request->file('thesis')->getClientMimeType()
                ]
            );
        }



        return response()->noContent(204,[
            'message' => 'thesis updated successfully',
        ]);
    }
    public function updatePoster(Request $request, Project $project, FileUploadService $fileService): Response
    {

        $request->validate([
            'Poster' => 'nullable|file',
//            'Poster' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt',

        ]);

        // Poster upload
        if ($request->file('poster')) {
            if (!empty($project->public_id_for_poster)) {
                cloudinary()->uploadApi()->destroy($project->public_id_for_poster);
            }
            $fileService->uploadAndAttach(
                $request->file('poster'),
                $project,
                'poster',
                'Projects/Poster',
                'public_id_for_poster',
                'raw',
                [
                    'poster_name' => empty($project->poster_name)
                        ? $request->file('poster')->getClientOriginalName()
                        : $project->poster_name,
                    'poster_type' => $request->file('poster')->getClientMimeType()
                ]
            );
        }



        return response()->noContent(204,[
            'message' => 'poster updated successfully',
        ]);
    }
    public function updateVideo(Request $request, Project $project, FileUploadService $fileService): Response
    {

        $request->validate([
            'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg,video/quicktime',
        ]);
        // Video upload
        if ($request->file('video')) {
            if (!empty($project->public_id_for_video)) {
                cloudinary()->uploadApi()->destroy($project->public_id_for_video);
            }
            $fileService->uploadAndAttachVideo(
                $request->file('video'),
                $project,
                'video',
                'Projects/videos',
                'public_id_for_video',
            );
        }


        return response()->noContent(204,[
            'message' => 'Video updated successfully',
        ]);
    }

}
