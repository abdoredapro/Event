<?php

namespace App\Concerns;

use App\Enum\UserStatus;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Otp;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait ModelHelper {

    /**
     * Check if user is "Active".
     */
    public function isActive(): bool
    {
        return $this->status == UserStatus::ACTIVE;
    }

    /**
     * Check if user is "InActive"
     */
    public function inActive(): bool
    {
        return $this->status == UserStatus::INACTIVE;
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function token(): string
    {
        return $this->createToken('auth', ['*'])->plainTextToken;
    }

    /**
     * Get user OTP code.
     */
    public function otpCode(): MorphOne
    {
        return $this->morphOne(Otp::class, 'otpable');
    }

    /**
     * Generate OTP code for (user or provider).
     */
    public function generateOTP(): string
    {
        $code = rand(1000, 100000);

        $this->otpCode()->updateOrCreate([], [
            'code' => $code,
            'expire_at' => now()->addMinutes(5),
        ]);

        return $code;
    }
    
    /**
     * wallet for (User, Provider)
     *
     * @return MorphOne
     */
    public function wallet(): MorphOne
    {
        return $this->morphOne(Wallet::class, 'user');
    }
}