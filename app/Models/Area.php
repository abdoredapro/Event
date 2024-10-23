<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id', 'city_id', 'name'
    ];

    /**
     * Get city.
     */
    public function city(): BelongsTo 
    {
        return $this->belongsTo(City::class);
    }


}
