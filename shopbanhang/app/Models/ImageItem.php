<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageItem extends Model
{   
    protected $table = "image_items";
    public $timestamps = false;
    use HasFactory;
}
