<?php

namespace Dealskoo\Review\Http\Controllers\Seller;

use Dealskoo\Seller\Http\Controllers\Controller as SellerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends SellerController
{
    public function upload(Request $request)
    {
        $request->validate([
            'editormd-image-file' => ['required', 'image', 'max:1000']
        ]);

        $image = $request->file('editormd-image-file');
        $filename = time() . '.' . $image->guessExtension();
        $path = $image->storeAs('review/images/' . date('Ymd'), $filename);
        return response()->json([
            'success' => 1,
            'url' => Storage::url($path)
        ]);
    }
}
