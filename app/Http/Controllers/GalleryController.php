<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;

class GalleryController extends Controller
{
    public function showGallery(Request $request)
    {
        $sizes = Size::all()->pluck('code')->toArray();

        $galleryPath = public_path('gallery');
        $images = glob("{$galleryPath}/*.jpg");

        $imageNames = array_map(function ($path) {
            return basename($path, '.jpg');
        }, $images);

        $selectedImages = array_slice($imageNames, 0, 10);

        $isMobile = $this->isMobile($request);

        return view('gallery', [
            'images' => $selectedImages,
            'isMobile' => $isMobile,
            'sizes' => $sizes,
        ]);
    }

    private function isMobile(Request $request)
    {
        $userAgent = strtolower($request->header('User-Agent'));

        $mobileAgents = ['iphone', 'ipad', 'android', 'blackberry', 'opera mini', 'windows phone'];

        foreach ($mobileAgents as $agent) {
            if (strpos($userAgent, $agent) !== false) {
                return true;
            }
        }

        return false;
    }
}
