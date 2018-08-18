<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
    // use SoftDeletes;

    protected $table = 'product';

    protected $primaryKey = 'id';
    
    protected $fillable = array('name');

}
