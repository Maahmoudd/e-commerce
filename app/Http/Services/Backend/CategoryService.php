<?php

namespace App\Http\Services\Backend;

use App\Models\Category;
use Illuminate\Support\Str;

class CategoryService
{
    public function create($request, $object)
    {
        $request['slug'] = Str::slug($request['name']);
        $object::create($request);
    }

    public function update($request, $id, $object)
    {
        $category = $object::findOrFail($id);
        $request['slug'] = Str::slug($request['name']);
        $category->update($request);
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
        $category = $object::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();
    }

}
