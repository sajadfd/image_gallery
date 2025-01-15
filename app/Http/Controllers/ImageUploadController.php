<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    /**
     * Display the image upload form.
     *
     * @return \Illuminate\View\View
     */
    public function showUploadForm()
    {
        return view('upload-form');
    }

    public function handleUpload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,JPG|max:5120', // Max 5MB
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $hash = md5_file($file->getRealPath());

            $uniqueFilename = $hash . '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('gallery');

            $storedImagePath = $destinationPath . '/' . $uniqueFilename;

            if (!file_exists($storedImagePath)) {
                try {
                    $file->move($destinationPath, $uniqueFilename);
                } catch (\Exception $e) {
                    Log::error('Image Upload Failed: ' . $e->getMessage());

                    return redirect()->back()->with('error', 'Failed to upload image. Please try again.');
                }
            }

            Cache::forget('gallery_images');

            return redirect()->route('gallery.index')->with('success', 'Image uploaded successfully!');
        }

        return redirect()->back()->with('error', 'No image was uploaded.');
    }
}
