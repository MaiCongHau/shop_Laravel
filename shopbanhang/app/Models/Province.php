<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $keyType = 'string';
    public function districts()
    {
        return $this->hasMany(District::class);
    }
    
}
