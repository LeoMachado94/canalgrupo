<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function uploadFile(
        Request $request,
        string $attrName,
        string $destiny,
        string $fileName,
        string $deleteFile = null
    ) {
        if (!empty($deleteFile) && Storage::exists($deleteFile)) {
            Storage::delete($deleteFile);
        }
        // Get just ext
        $extension = $request->file($attrName)->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $fileName . '.' . $extension;
        // Upload Image
        $path = $request->file($attrName)->storeAs(
            $destiny,
            $fileNameToStore,
            ['disk' => 'spaces']
        );
        return "{$path}";
    }
}
