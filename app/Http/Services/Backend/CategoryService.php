<?php

namespace App\Http\Services\Backend;

use App\Traits\ImageUploadTrait;
use Illuminate\Support\Str;

class CategoryService
{
    use ImageUploadTrait;
    public function create($request, $object)
    {
        $slug = Str::slug($request['name']);
        $request['slug'] = $slug;

        if (isset($request['logo']) && !empty($request['logo'])) {
            $request['logo'] = $this->uploadImage($request, 'logo', 'uploads');
        }
        $object::create($request);
    }

    public function update($request, $id, $object, $photo)
    {
        $object = $object::findOrFail($id);
        $request['slug'] = Str::slug($request['name']);
        if (isset($request['logo']) && !empty($request['logo'])) {
            $request['logo'] = $this->updateImage($request, $photo, 'uploads', $object[$photo]);
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
    }

}
