<?php

namespace App\Traits;


trait ImageUploadTrait
{
    public function uploadImage($request, $inputName, $path)
    {
        if (isset($request[$inputName])) {
            $image = $request[$inputName];
            $imageName = 'media_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path($path), $imageName);

            return $path. '/' .$imageName;
        }
        return null;
    }

}
