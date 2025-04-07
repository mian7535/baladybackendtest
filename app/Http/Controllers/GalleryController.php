<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{

    public function index(Request $request)
    {
        if ($request->has('load')) {
            $url = config('service.baseUrlImage') . '/' . $request->get('load');
    
            try {
                if (isset($request->type) && $request->type == 'pdf') {
                    // Set PDF headers
                    return response()->make(file_get_contents($url), 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'inline; filename="test.pdf"',
                    ]);
                } else {
                    // Set image headers based on file extension
                    $fileExtension = Str::afterLast($request->get('load'), '.');
                    $contentType = 'image/' . $fileExtension;
    
                    return response(file_get_contents($url))
                        ->header('Content-Type', $contentType);
                }
            } catch (\Exception $e) {
                // Handle any exceptions that occur
                return response()->json(['error' => 'File not found or unable to stream.'], 404);
            }
        }
    
        return response()->json(['error' => 'File not specified.'], 400);
    }

}
