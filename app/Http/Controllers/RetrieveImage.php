<?php

namespace App\Http\Controllers;

use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class RetrieveImage
{
    /**
     * Retrieve ir image file.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $file = Media::query()
                ->where(function (Builder $query) use ($request) {
                    $query->where([
                        'model_type' => Inspection::class,
                        'model_id' => $request->model_id,
                        'collection_name' => 'ir',
                        'name' => $request->filename,
                    ])
                    ->orWhere(function (Builder $query) use ($request) {
                        $query->where([
                            'model_type' => Inspection::class,
                            'model_id' => $request->model_id,
                            'collection_name' => 'rgb',
                            'name' => $request->filename,
                        ]);
                    })
                    ->orWhere(function (Builder $query) use ($request) {
                        $query->where([
                            'model_type' => Inspection::class,
                            'model_id' => $request->model_id,
                            'collection_name' => 'default',
                            'name' => $request->filename,
                        ]);
                    });
                })
                ->first();

            return response()->json([
                'status' => 'succeeded',
                'data' => [
                    'file_name' => $file->file_name,
                    'file_url' => Storage::temporaryUrl($file->getPath(), now()->addMinutes(60)),
                    'name' => $file->name,
                    'size' => $file->human_readable_size,
                ],
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => __("The requested resource doesn't exist."),
            ], 404);
        }
    }
}
