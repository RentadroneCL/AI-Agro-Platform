<?php

use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FileUploads;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RetrieveImage;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\UploadOnboardingFiles;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/welcome', 'welcome');

Route::get('/', function () {
    return Auth::user() ? redirect('dashboard') : redirect('login');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', Dashboard::class)->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->resource('/site', SiteController::class);

Route::middleware(['auth:sanctum', 'verified'])->resource('/inspection', InspectionController::class);

Route::middleware(['auth:sanctum', 'verified'])
    ->post('/{inspection}/files-upload/{collection}', FileUploads::class)
    ->name('files-upload');

Route::middleware(['auth:sanctum', 'verified', 'role:administrator'])->resource('/user', UserController::class);

Route::middleware(['auth:sanctum', 'verified'])
    ->post('/upload-onboarding-files', UploadOnboardingFiles::class)
    ->name('upload-onboarding-files');

Route::middleware(['auth:sanctum', 'verified'])
    ->post('/retrieve-image-file', RetrieveImage::class)
    ->name('retrieve-image');
