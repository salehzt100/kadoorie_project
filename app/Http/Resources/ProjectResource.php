<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'abstract' => $this->abstract,
            'faculty_department' => new FacultyDepartmentResource($this->facultyDepartment),
            'category' => new CategoryResource($this->category),
            'visibility' => $this->visibility,
            'video' => $this->video,
            'thesis' => $this->thesis,
            'poster' => $this->poster,
            'thesis_name' => $this->thesis_name,
            'poster_name' => $this->poster_name,
            'thesis_type' => $this->thesis_type,
            'poster_type' => $this->poster_type,
            'students' => StudentResource::collection($this->students),
            'supervisors' => SupervisorResource::collection($this->supervisors),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];    }
}
