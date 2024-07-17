<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\ZohoAccess;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\Exceptions\UnknownType;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * Handles file upload for documents and other files
 */
class FileUploader
{

    /**
     * Upload media for a given model
     *
     * @param Model $model
     * @param $file
     * @return Media
     * @throws UnknownType
     */
    public function uploadMediaForModelFromRequest(Model $model, $file, $collectionPath = 'media') {
        if (!$model instanceof HasMedia) {
            throw new UnknownType('Model '.get_class($model).' does not support uploading media');
        }
        $model
            ->addFromMediaLibraryRequest($file)
            ->toMediaCollection($collectionPath);
    }

}
