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
        if (isset($request[$inputName])) {
            $this->deleteImage($oldPath);

            $image = $request[$inputName];
            $ext = $image->getClientOriginalExtension();
            $imageName = 'media_'.uniqid().'.'.$ext;

            $image->move(public_path($path), $imageName);
            $finalPath = $path.'/'.$imageName;
            return $finalPath;
        }
    }
    public function uploadMultiImage($request, $inputName, $path)
    {
        $imagePaths = [];

        if (isset($request[$inputName])) {

            $images = $request[$inputName];

            foreach($images as $image){

                $ext = $image->getClientOriginalExtension();
                $imageName = 'media_'.uniqid().'.'.$ext;

                $image->move(public_path($path), $imageName);

                $imagePaths[] =  $path.'/'.$imageName;
            }

            return $imagePaths;
        }
    }

    public function deleteImage(string $path)
    {
        if(File::exists(public_path($path))){
            File::delete(public_path($path));
        }
    }

}
