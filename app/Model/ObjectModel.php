<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ObjectModel extends Model
{
    // use SoftDeletes;

    protected $table = 'object';

    protected $primaryKey = 'id';

    protected $fillable = array('product_id', 'name', 'url', 'preview', 'origin', 'frame', 'design', 'fov', 'texture', 'camera_pos_x','camera_pos_y', 'camera_pos_z', 'camera_rot_x', 'camera_rot_y', 'camera_rot_z', 'object_pos_x', 'object_pos_y', 'object_pos_z', 'object_rot_x', 'object_rot_y', 'object_rot_z');

    public function product() {
    	return $this->belongsTo(ProductModel::class, 'product_id');
    }
}
