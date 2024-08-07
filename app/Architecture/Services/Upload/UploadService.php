<?php

namespace App\Architecture\Services\Upload;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadService {
    public function uploadImage(string $imageBase64) {
        // Extract the image extension from the base64 string
        preg_match("/^data:image\/([a-zA-Z0-9]+);base64/i", $imageBase64, $match);
        $extension = $match[1]; // Get the extension from the base64 data

        // Remove the base64 prefix to get the actual image data
        $image = base64_decode(preg_replace('/^data:image\/(.*);base64,/', '', $imageBase64));

        // Generate a unique filename
        $imageName = Str::random(10) . '.' . $extension;

        // Define the storage path
        $path = 'images/' . $imageName;

        // Store the image using the determined extension
        Storage::disk('public')->put($path, $image);

        return $path;
    }
}
