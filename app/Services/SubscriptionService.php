<?php
namespace App\Services;

use App\Models\User;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class SubscriptionService {
    public function subscribe(User $user, SubscriptionPlan $plan, $paymentMethod) {
        DB::beginTransaction();
        try {
            Payment::create([
                'user_id' => $user->id,
                'payment_method' => $paymentMethod,
                'transaction_id' => uniqid('SUB-'),
                'amount' => $plan->price,
                'status' => 'success',
                'type' => 'subscription'
            ]);

            UserSubscription::create([
                'user_id' => $user->id,
                'subscription_plan_id' => $plan->id,
                'starts_at' => now(),
                'ends_at' => now()->addDays($plan->duration_days),
                'status' => 'active'
            ]);

            $user->update(['role' => 'premium']);
            
            if ($plan->bonus_points > 0) {
                app(PointsService::class)->earnPoints($user, $plan->bonus_points, 'Bonus Langganan ' . $plan->name);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}