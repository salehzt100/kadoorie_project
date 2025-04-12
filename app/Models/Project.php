<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Project extends Model
{
    protected $fillable = [
        'title',
        'abstract',
        'faculty_department_id',
        'category_id',
        'visibility',
        'video',
        'thesis',
        'poster',
        'thesis_name',
        'poster_name',
        'thesis_type',
        'poster_type',
        'public_id_for_video',
        'public_id_for_thesis',
        'public_id_for_poster',
    ];

    /**
     * Get the faculty department that owns the project.
     */
    public function facultyDepartment(): BelongsTo
    {
        return $this->belongsTo(FacultyDepartment::class);
    }

    /**
     * Get the category associated with the project.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The students that belong to the project.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'project_students');
    }

    /**
     * The supervisors that belong to the project.
     */
    public function supervisors(): BelongsToMany
    {
        return $this->belongsToMany(Supervisor::class, 'project_supervisors');
    }
}
