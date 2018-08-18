<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Model\ObjectModel;
use App\Model\ProductModel;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function getList(Request $request) {
        $product = ProductModel::all();
        return $product->toArray();
    }

    public function getObjectDetail(Request $request, $id) {
        $object = ObjectModel::where('id', $id)->select(
            'id', 'name', 'texture', 'preview', 'origin', 'frame', 'design', 'fov',
            'url as object',
            'camera_pos_x as cameraPosX',
            'camera_pos_y as cameraPosY',
            'camera_pos_z as cameraPosZ',
            'camera_rot_x as cameraRotX',
            'camera_rot_y as cameraRotY',
            'camera_rot_z as cameraRotZ',
            'object_pos_x as objectPosX',
            'object_pos_y as objectPosY',
            'object_pos_z as objectPosZ',
            'object_rot_x as objectRotX',
            'object_rot_y as objectRotY',
            'object_rot_z as objectRotZ'
        )->first();

        if(!$object) {
            return ['errors' => true, 'message' => ['Error: Object Not Found']];
        }

        $object = $object->toArray();
        $object['texture'] = asset($object['texture']);
        $object['preview'] = asset($object['preview']);
        $object['origin'] = asset($object['origin']);
        $object['frame'] = asset($object['frame']);
        $object['design'] = asset($object['design']);
        $object['object'] = asset($object['object']);

        return ['errors' => false, 'data' => $object];
    }

    public function updateObject(Request $request, $id) {

        $data = $request->json()->all();
        $object = ObjectModel::find($id);
        if(!$object) {
            return ['errors' => true, 'message' => ['Error: Object Not Found']];
        }
        $object->update([
            $data['name'] => $data['value']
        ]);
        if(in_array($data['name'], ['origin', 'frame', 'design', 'texture'])) {
            $data['value'] = asset($data['value']);
        }
        
        return ['errors' => false, 'data' => $data];
    }
}
