<?php
namespace App\Services;

use App\Models\User;
use App\Models\PointsTransaction;
use Illuminate\Support\Facades\DB;

class PointsService {
    public function earnPoints(User $user, $amount, $description, $orderId = null) {
        DB::transaction(function() use ($user, $amount, $description, $orderId) {
            PointsTransaction::create([
                'user_id' => $user->id,
                'order_id' => $orderId,
                'type' => 'earn',
                'amount' => $amount,
                'description' => $description
            ]);
            $user->increment('points', $amount);
        });
    }

    public function redeemPoints(User $user, $amount, $description) {
        if ($user->points < $amount) {
            throw new \Exception("Insufficient points");
        }
        
        DB::transaction(function() use ($user, $amount, $description) {
            PointsTransaction::create([
                'user_id' => $user->id,
                'type' => 'redeem',
                'amount' => $amount,
                'description' => $description
            ]);
            $user->decrement('points', $amount);
        });
    }
}