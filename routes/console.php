<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\UserSubscription;
use App\Models\User;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Cron Job: Check for expired premium subscriptions
Schedule::call(function () {
    $expiredSubscriptions = UserSubscription::where('status', 'active')
                                            ->where('ends_at', '<', now())
                                            ->get();
                                            
    foreach ($expiredSubscriptions as $sub) {
        $sub->update(['status' => 'expired']);
        $user = User::find($sub->user_id);
        if ($user && $user->role == 'premium') {
            $user->update(['role' => 'user']);
        }
    }
})->dailyAt('00:00')->name('check_expired_premium')->withoutOverlapping();
