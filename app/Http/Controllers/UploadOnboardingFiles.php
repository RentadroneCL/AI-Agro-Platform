<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\MediaLibrary\MediaCollections\FileAdder;

class UploadOnboardingFiles extends Controller
{
    /**
     * Upload onboarding associated files.
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        Validator::make(request('files'), ['files.*' => 'file|max:943718400']);

        $files = Auth::user()->onboarding->addAllMediaFromRequest()->each(fn(FileAdder $file) => $file->toMediaCollection('attachments'));

        return response()->json([
            'status' => 'succeeded',
            'affected_record' => $files,
        ]);
    }
}
