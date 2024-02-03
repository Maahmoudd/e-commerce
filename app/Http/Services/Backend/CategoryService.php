<?php

namespace App\Http\Services\Backend;

use App\Traits\ImageUploadTrait;
use Illuminate\Support\Str;

class CategoryService
{
    use ImageUploadTrait;
    public function create($request, $object, $image, $storagePath)
    {
        $slug = Str::slug($request['name']);
        $request['slug'] = $slug;

        if (isset($request[$image]) && !empty($request[$image])) {
            $request[$image] = $this->uploadImage($request, $image, $storagePath);
        }
        $object::create($request);
    }

    public function update($request, $id, $object, $image, $storagePath)
    {
        $object = $object::findOrFail($id);
        $request['slug'] = Str::slug($request['name']);
        if (isset($request[$image]) && !empty($request['logo'])) {
            $request[$image] = $this->updateImage($request, $image, $storagePath, $object[$image]);
        }
        $object->update($request);
    }

    public function destroy($id, $object, $innerObject, $objectField)
    {
        $object = $object::findOrFail($id);
        $innerObject = $innerObject::where($objectField, $object->id)->count();

        if($innerObject > 0){
            return ['status' => 'error', 'message' => 'This items contain, sub items for delete this you have to delete the sub items first!'];
        }
        $object->delete();

        return ['status' => 'success', 'Deleted Successfully!'];
    }

    public function changeStatus($request, $object)
    {
        $object = $object::findOrFail($request->id);
        $object->status = $request->status == 'true' ? 1 : 0;
        $object->save();
        return response(['message' => 'Status has been changed!']);
    }

}
