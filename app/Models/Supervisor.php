<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supervisor extends Model
{
    // Specify the attributes that can be mass-assigned
    protected $fillable = [
        'name',
        'email',
        'faculty_department_id',
        'image',
        'public_id_for_image'
    ];


    /**
     * Get the faculty department associated with the supervisor.
     */
    public function facultyDepartment() :belongsTo
    {
        return $this->belongsTo(FacultyDepartment::class);
    }
}
