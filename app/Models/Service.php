<?php

namespace App\Models;

use App\Enum\Assets;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'sub_category_id', 'provider_id', 'name', 
        'image', 'price', 'description'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function image(): Attribute
    {
        return new Attribute(
            get: fn($value) => asset(Storage::url(Assets::SERVICE_IMAGE->value . $value)), 
        );
    }

    public function images(): HasMany
    {
        return $this->hasMany(ServiceImages::class, 'service_id', 'id');
    }

}
