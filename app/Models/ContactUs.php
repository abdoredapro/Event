<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use App\Models\Provider;


final class ContactUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'username', 'email', 'phone', 'message'
    ];

    public static function rule(): array 
    {
        return [
            'username' => ['required', 'string', 'max:255', Rule::exists(Provider::class, 'username')],
            'email' => ['required', 'email', Rule::exists(Provider::class, 'email')],
            'phone' => ['required', 'string', Rule::exists(Provider::class, 'phone')],
            'message' => ['required', 'string'],
        ];
    }
}
