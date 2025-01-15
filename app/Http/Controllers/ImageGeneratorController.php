<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Size;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ImageGeneratorController extends Controller
{
    public function generate(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'size' => 'required|string|exists:sizes,code',
        ]);

        $hash = $request->input('name');
        $sizeCode = $request->input('size');

        $size = Size::where('code', $sizeCode)->first();

        if (!$size) {
            return response('Invalid size parameter.', Response::HTTP_BAD_REQUEST);
        }

        $originalPath = public_path("gallery/{$hash}.jpg");
        $cacheFilename = "{$hash}_{$sizeCode}.jpg";
        $cachePath = public_path("cache/{$cacheFilename}");

        $cacheKey = "image_cache:{$hash}:{$sizeCode}";

        if (Cache::has($cacheKey)) {
            $cachedImagePath = Cache::get($cacheKey);
            if (file_exists($cachedImagePath)) {
                return response()->file($cachedImagePath, [
                    'Content-Type' => 'image/jpeg',
                    'Cache-Control' => 'max-age=31536000, public',
                ]);
            } else {
                Cache::forget($cacheKey);
            }
        }

        if (!file_exists($originalPath)) {
            return response('Original image not found.', Response::HTTP_NOT_FOUND);
        }


        try {
            $this->resizeImage($originalPath, $cachePath, $size->width, $size->height);


            Cache::put($cacheKey, $cachePath, now()->addDays(7)); // Cache for 7 days
        } catch (\Exception $e) {

            Log::error("Image resizing failed: " . $e->getMessage());
            return response('Image processing failed.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        return response()->file($cachePath, [
            'Content-Type' => 'image/jpeg',
            'Cache-Control' => 'max-age=31536000, public',
        ]);
    }

    private function resizeImage($originalPath, $cachePath, $maxWidth, $maxHeight)
    {

        list($width, $height, $type) = getimagesize($originalPath);

        if (!$width || !$height) {
            throw new \Exception('Invalid image dimensions.');
        }

        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = (int)($width * $ratio);
        $newHeight = (int)($height * $ratio);

        $srcImage = imagecreatefromjpeg($originalPath);
        if (!$srcImage) {
            throw new \Exception('Failed to create image from source.');
        }

        $dstImage = imagecreatetruecolor($newWidth, $newHeight);
        if (!$dstImage) {
            imagedestroy($srcImage);
            throw new \Exception('Failed to create destination image.');
        }


        if (!imagecopyresampled(
            $dstImage,
            $srcImage,
            0,
            0,
            0,
            0,
            $newWidth,
            $newHeight,
            $width,
            $height
        )) {
            imagedestroy($srcImage);
            imagedestroy($dstImage);
            throw new \Exception('Failed to resample image.');
        }


        if (!imagejpeg($dstImage, $cachePath, 85)) {
            imagedestroy($srcImage);
            imagedestroy($dstImage);
            throw new \Exception('Failed to save resized image.');
        }


        imagedestroy($srcImage);
        imagedestroy($dstImage);
    }
}
