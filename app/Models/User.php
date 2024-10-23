<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Concerns\ModelHelper;
use App\Enum\Assets;
use App\Enum\GenderStatus;
use App\Enum\UserStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasApiTokens, ModelHelper;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password', 'image', 'fcm_token', 'username',
        'birthdate', 'gender', 'status', 'country_id', 'city_id', 'area_id'
    ];

    protected $with = [
        'country', 'city', 'area'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            get: fn() => $this->image ? asset(Storage::url(Assets::USER_IMAGE . $this->image)) : asset('avatar.png'),
        );
    }



}
