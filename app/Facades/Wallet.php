<?php
namespace App\Facades;

use App\Repositories\Wallet\WalletRepositoryInterface;
use Illuminate\Support\Facades\Facade;

class Wallet extends Facade {

    protected static function getFacadeAccessor(): string
    {
        return WalletRepositoryInterface::class;
    }

}