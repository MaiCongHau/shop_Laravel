<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ward extends Model
{
    use HasFactory;
    /**
     * Get the district te ward
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    protected $keyType = 'string';
    public function district()
    {
        return $this->belongsTo(District::class);
    }
    
}
