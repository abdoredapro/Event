<?php

namespace App\Models;

use App\Concerns\ModelHelper;
use App\Enum\Assets;
use App\Enum\GenderStatus;
use App\Enum\UserStatus;
use App\Observers\ProviderObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

#[ObservedBy([ProviderObserver::class])]
final class Provider extends User
{
    use HasFactory, ModelHelper, Notifiable, HasApiTokens;

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'image', 'fcm_token', 'username',
        'birthdate', 'gender', 'status', 'gender', 'country_id', 'city_id', 'area_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class, 
            'gender' => GenderStatus::class
        ];
    }


    /**
     * Get user image.
     */
    public function imageUrl(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->image ? asset(Storage::url(Assets::PROVIDER_IMAGE->value . $this->image)) : asset('avatar.png'),
        );
    }
}
