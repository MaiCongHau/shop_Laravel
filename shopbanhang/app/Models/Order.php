<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    public $timestamps = false;

    /**
     * Get all of the comments for the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function order_item()
    {
        return $this->hasMany(Order_item::class, 'order_id', 'id');
    }
    public function status()
    {
        return $this->belongsTo(Statuse::class, 'order_status_id', 'id');
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'shipping_ward_id', 'id');
    }
   
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

}