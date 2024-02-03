<?php

namespace App\Http\Services\Backend;

use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileService
{
    use ImageUploadTrait;

    public function profileUpdate($request, $image, $user, $storagePath)
    {
        if (isset($request[$image]) && !empty($request[$image])) {
            if (File::exists(public_path($user[$image]))){
                File::delete(public_path($user[$image]));
            }
            $request[$image] = $this->uploadImage($request, $image, $storagePath);
        }
        $user->update($request);
    }


}
