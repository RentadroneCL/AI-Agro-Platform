<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Illuminate\Http\JsonResponse;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

class FileUploads extends Controller
{
    /**
     * Handling file uploading and storing.
     *
     * @param int $id
     * @param string $collection
     *
     * @return JsonResponse
     */
    public function __invoke(int $id = null, string $collection = 'default'): JsonResponse
    {
        $inspection = Inspection::findOrFail($id);

        $inspection->addAllMediaFromRequest()
            ->each(fn(FileAdder $file) => $file->toMediaCollection($collection));

        return response()->json([
            'status' => 'succeeded',
            'affected_record' => $inspection,
        ]);
    }
}
