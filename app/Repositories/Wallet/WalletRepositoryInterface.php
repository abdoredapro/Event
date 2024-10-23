<?php

namespace App\Repositories\Wallet;

use App\Models\Provider;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;

interface WalletRepositoryInterface {

    public function create(Provider|User $model): Wallet;

    public function deposit(Provider|User $model, float|int $amount): Wallet;
    
    public function withdraw(Provider|User $model, float|int $amount): Wallet;

    public function hasSufficientMoney(Provider|User $model, float|int $amount): ?JsonResponse;
}