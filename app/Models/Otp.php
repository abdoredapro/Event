<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'otpable_type', 'otpable_id', 'code', 'expire_at'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expire_at' => 'datetime',
        ];
    }

    /**
     * Get the parent model (User or Provider).
     */
    public function otpable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Check if code is expired.
     */
    public function isExpired()
    {
        return $this->expire_at->isPast();
    }
}
