<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_type',
        'user_id',
        'balance',
    ];
    
}
