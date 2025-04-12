<?php
namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * Upload and update a file for a model.
     *
     * @param UploadedFile $file The file to upload
     * @param Model $model The model instance to update
     * @param string $attributeName Name of the file field (e.g. 'image', 'thesis')
     * @param string $folder Cloudinary folder (e.g. 'Students', 'Projects/Thesis')
     * @param string $publicIdField DB field name that stores the Cloudinary public ID
     * @param array|null $extraAttributes Extra fields to set (e.g. file name/type)
     * @return void
     */
    public function uploadAndAttach(
        UploadedFile $file,
        Model $model,
        string $attributeName,
        string $folder,
        string $publicIdField,
        string $resource_type,
        ?array $extraAttributes = [],
    ): void {
        // Delete old file if it exists
        if (!empty($model->{$publicIdField})) {
            cloudinary()->uploadApi()->destroy($model->{$publicIdField});
        }

        // Upload new file
        $uploaded = cloudinary()->uploadApi()->upload(
            $file->getRealPath(),
            [
                \GuzzleHttp\RequestOptions::EXPECT => false,
                'folder' => $folder,
                'resource_type' => $resource_type,
                'format'=>$file->getClientOriginalExtension(),
                'display_name'=>$file->getClientOriginalName(),
            ]
        );

        // Set attributes
        $model->{$attributeName} = $uploaded['secure_url'];
        $model->{$publicIdField} = $uploaded['public_id'];

        // Any custom attributes (optional)
        foreach ($extraAttributes as $key => $value) {
            $model->{$key} = $value;
        }

        $model->save();
    }




    /**
     * Upload and update a video file for a model.
     *
     * @param UploadedFile $file The video file to upload
     * @param Model $model The model instance to update
     * @param string $attributeName Name of the file field (e.g. 'video')
     * @param string $folder Cloudinary folder (e.g. 'Students/Videos')
     * @param string $publicIdField DB field name that stores the Cloudinary public ID
     * @param array|null $extraAttributes Extra fields to set (e.g. file name/type)
     * @return void
     */
    public function uploadAndAttachVideo(
        UploadedFile $file,
        Model $model,
        string $attributeName,
        string $folder,
        string $publicIdField,
        ?array $extraAttributes = [],
    ): void {
        // Delete old video if it exists
        if (!empty($model->{$publicIdField})) {
            cloudinary()->uploadApi()->destroy($model->{$publicIdField},
                [
                    'resource_type' => 'video'
                ]);
        }

        // Store temporarily to ensure readability and path access
        $storedPath = $file->store('temp_videos', 'local');
        $absolutePath = Storage::disk('local')->path($storedPath);

        if (!file_exists($absolutePath) || !is_readable($absolutePath)) {
            throw new \RuntimeException('File not found or not readable: ' . $absolutePath);
        }

        // Upload new video
        $uploaded = cloudinary()->uploadApi()->upload(
            $absolutePath,
            [
                \GuzzleHttp\RequestOptions::EXPECT => false,
                'folder' => $folder,
                'resource_type' => 'video',
                'format'=>$file->getClientOriginalExtension(),
                'display_name'=>$file->getClientOriginalName(),
            ]
        );

        // Delete temporary file
        Storage::disk('local')->delete($storedPath);

        // Set video URL and public ID
        $model->{$attributeName} = $uploaded['secure_url'];
        $model->{$publicIdField} = $uploaded['public_id'];

        // Set any additional attributes
        foreach ($extraAttributes as $key => $value) {
            $model->{$key} = $value;
        }

        $model->save();
    }

}
