<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileModel extends Model
{
    // use SoftDeletes;

    protected $table = 'file';

    protected $primaryKey = 'id';
    
    protected $fillable = array('name', 'url', 'size');

}
