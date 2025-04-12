<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TiptapImageUploadController extends Controller
{
    public function upload(Request $request)
{
    // Validate the uploaded image
    $request->validate([
        'file' => 'required|image|max:10240', // 10MB max size
    ]);

    // Store the image on S3 in the 'posts/media' directory
    $path = $request->file('file')->store('posts/media', 's3');

    // Manually generate the S3 URL
    $s3Url = Storage::disk('s3')->url($path); // This gives you the URL from S3

    // Ensure we remove any potential unwanted prefix (like the app domain)
    $url = str_replace(url('/'), '', $s3Url); // Removes the base URL (if it appears) from the S3 URL

    // Return the correct S3 URL as a JSON response
    return response()->json(['url' => $url]);
}

}
