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

        // Generate the URL for the uploaded image
        $url = Storage::disk('s3')->url($path);

        // Return the image URL as a JSON response
        return response()->json(['url' => $url]);
    }
}
