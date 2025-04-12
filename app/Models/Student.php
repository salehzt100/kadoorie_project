<?php

namespace App\Models;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Student extends Model
{

    protected $fillable = [
        'name',
        'email',
        'faculty_department_id',
        'image',
        'public_id_for_image'
    ];

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ( $value) =>  $value ? : $value = 'https://res.cloudinary.com/dbzkboutj/image/upload/v1736553373/Patient/mlixywcfkcgir94eldtr.png',
        );
    }

    /**
     * Delete the current avatar from Cloudinary, if exists.
     */
    public function deleteImage() :void
    {
        if ($this->image) {
            $this->image = null;
            if ($this->public_id_for_image){
                Cloudinary::destroy($this->public_id_for_image);
                $this->public_id_for_image = null;
            }

        }
    }

    /**
     * Get the faculty department associated with the student.
     */
    public function facultyDepartment(): BelongsTo
    {
        return $this->belongsTo(FacultyDepartment::class);
    }
}
