<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageGeneratorController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ImageUploadController;

Route::get('/generator', [ImageGeneratorController::class, 'generate'])->name('image.generator')->middleware('throttle:60,1');
Route::get('/', [GalleryController::class, 'showGallery'])->name('gallery.index');

Route::get('/index', [ImageUploadController::class, 'showUploadForm'])->name('image.upload.form');
Route::post('/index', [ImageUploadController::class, 'handleUpload'])->name('image.upload');
