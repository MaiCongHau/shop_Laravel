<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\ImageItem;
use App\Models\Comment;

class ViewProduct extends Model
{
    
    use HasFactory;
    public $timestamps = false;
    protected $table = "view_products";

    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * Get all of the comments for the ViewProduct
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function imageItem() 
    {
        // nếu ta không truyền khóa ngoại "product_id" thì nó mặc định sẽ tự sinh ra khóa ngoại bằng cách ghép tên class thành khóa ngoại tên là 
        // view_product_id mà trong bảng ImageItem thì nó éo có khóa ngoại nào tên như vậy, 
        // mà khóa ngoại của nó là thằng "product_id" nên mình phải custom như z
        return $this->hasMany(ImageItem::class,"product_id");
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class,"brand_id");
    }
    public function comments() 
    {
        // nếu ta không truyền khóa ngoại "product_id" thì nó mặc định sẽ tự sinh ra khóa ngoại bằng cách ghép tên class thành khóa ngoại tên là 
        // view_product_id mà trong bảng ImageItem thì nó éo có khóa ngoại nào tên như vậy, 
        // mà khóa ngoại của nó là thằng "product_id" nên mình phải custom như z
        return $this->hasMany(Comment::class,"product_id");
    }
    
}