<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    use HasFactory;
    public $timestamps = false;
    
 
    public function viewproduct()
    {
        return $this->belongsTo(ViewProduct::class, 'product_id', 'id');
    }
}
