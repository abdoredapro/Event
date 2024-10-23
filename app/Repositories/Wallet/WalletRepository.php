<?php

namespace App\Repositories\Wallet;

use App\Helpers\ResponseHelper;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;

class WalletRepository implements WalletRepositoryInterface {
    
    public function create($model): Wallet
    {
        if($model->wallet) {
            return $model->wallet;
        }
        $wallet = $model->wallet()->create();

        return $wallet;
    }

    public function deposit($model, $amount): Wallet
    {
        $wallet = $model->wallet;

        $wallet->increment('balance', $amount);

        return $wallet;

    }

    public function withdraw($model, $amount): Wallet
    {
        $wallet = $model->wallet;

        $wallet->decrement('balance', $amount);

        return $wallet;
    }

    public function hasSufficientMoney($model, $amount): ?JsonResponse
    {
        $wallet = $model->wallet;
        if($wallet->balance >= $amount) {
            return ResponseHelper::success(__('home.wallet hass sufficient money'));
        }
        return ResponseHelper::error(__('home.wallet not have sufficient money'));
    }

}