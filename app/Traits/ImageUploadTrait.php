<?php

namespace App\Traits;


use Illuminate\Support\Facades\File;

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

    public function updateImage($request, $inputName, $path, $oldPath)
    {
        if($request->hasFile($inputName)){
            $this->deleteImage($oldPath);

            $image = $request[$inputName];
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_'.uniqid().'.'.$ext;

            $image->move(public_path($path), $imageName);
            $finalPath = $path.'/'.$imageName;
            return $finalPath;
        }
    }

    public function deleteImage(string $path)
    {
        if(File::exists(public_path($path))){
            File::delete(public_path($path));
        }
    }

}
