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

    public function getProductObjects(Request $request, $id) {
        $product = ProductModel::find($id);
        if(!$product) {
            return ['errors' => true, 'message' => ['Error: Object Not Found']];
        }
        $objects = $product->objects()->select(
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
        )->get();

        foreach ($objects as $key => $object) {
            $object->preview = asset($object->preview);
        }

        return ['errors' => false, 'data' => [
            'mainImage' => asset($product->img),
            'objects' => $objects->toArray()
        ]];
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
        $object['texture'] = $object['texture'] ? asset($object['texture']) : null;
        $object['preview'] = $object['preview'] ? asset($object['preview']) : null;
        $object['origin'] = $object['origin'] ? asset($object['origin']) : null;
        $object['frame'] = $object['frame'] ? asset($object['frame']) : null;
        $object['design'] = $object['design'] ? asset($object['design']) : null;
        $object['object'] = $object['object'] ? asset($object['object']) : null;

        return ['errors' => false, 'data' => $object];
    }

    public function updateObject(Request $request, $id) {

        $data = $request->json()->all();
        $object = ObjectModel::find($id);
        if(!$object) {
            return ['errors' => true, 'message' => ['Error: Object Not Found']];
        }
        $map = [
            'object' => 'url',
            'cameraPosX' => 'camera_pos_x',
            'cameraPosY' => 'camera_pos_y',
            'cameraPosZ' => 'camera_pos_z',
            'cameraRotX' => 'camera_rot_x',
            'cameraRotY' => 'camera_rot_y',
            'cameraRotZ' => 'camera_rot_z',
            'objectPosX' => 'object_pos_x',
            'objectPosY' => 'object_pos_y',
            'objectPosZ' => 'object_pos_z',
            'objectRotX' => 'object_rot_x',
            'objectRotX' => 'object_rot_y',
            'objectRotX' => 'object_rot_z',
        ];
        $name = false;
        if(isset($map[$data['name']])) {
            $name = $map[$data['name']];
        } else {
            $name = $data['name'];
        }
        $object->update([
            $name => $data['value']
        ]);
        if(in_array($data['name'], ['origin', 'frame', 'design', 'texture'])) {
            $data['value'] = asset($data['value']);
        }
        
        // 'camera_pos_x as cameraPosX',
        // 'camera_pos_y as cameraPosY',
        // 'camera_pos_z as cameraPosZ',
        // 'camera_rot_x as cameraRotX',
        // 'camera_rot_y as cameraRotY',
        // 'camera_rot_z as cameraRotZ',
        // 'object_pos_x as objectPosX',
        // 'object_pos_y as objectPosY',
        // 'object_pos_z as objectPosZ',
        // 'object_rot_x as objectRotX',
        // 'object_rot_y as objectRotY',
        // 'object_rot_z as objectRotZ'
        
        return ['errors' => false, 'data' => $data];
    }
}
