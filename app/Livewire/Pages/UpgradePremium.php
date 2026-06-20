<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\SubscriptionPlan;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;
use App\Traits\WithToast;

#[Layout('layouts.app')]
class UpgradePremium extends Component {
    use WithToast;

    public $selectedPlanId = null;
    public $paymentMethod = 'bank_transfer';

    public function selectPlan($planId) {
        $this->selectedPlanId = $planId;
    }

    public function processUpgrade(SubscriptionService $subService) {
        if (!Auth::check()) return redirect()->route('login');
        
        $this->validate([
            'selectedPlanId' => 'required|exists:subscription_plans,id',
            'paymentMethod' => 'required'
        ]);

        try {
            $plan = SubscriptionPlan::findOrFail($this->selectedPlanId);

            $subService->subscribe(Auth::user(), $plan, $this->paymentMethod);
            session()->flash('success', 'Payment successful! Welcome to Premium.');
            return redirect()->route('account');
        } catch (\Exception $e) {
            $this->notify('Payment failed: ' . $e->getMessage(), 'error');
        }
    }

    public function render() {
        return view('livewire.pages.upgrade-premium', [
            'plans' => SubscriptionPlan::where('is_active', true)->get()
        ]);
    }
}