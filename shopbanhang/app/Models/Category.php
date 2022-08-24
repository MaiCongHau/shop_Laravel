<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ViewProduct;

class Category extends Model
{
    use HasFactory;
    protected $table = "categories";
    public $timestamps = false;
    public function products()
    {  
        return $this->hasMany(ViewProduct::class,"category_id","id");
    }
  
}
