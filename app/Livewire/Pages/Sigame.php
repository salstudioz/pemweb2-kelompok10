<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Game;
use App\Models\GameAccess;
use App\Services\PointsService;
use Illuminate\Support\Facades\Auth;
use App\Traits\WithToast;

#[Layout('layouts.app')]
class Sigame extends Component
{
    use WithToast;

    public function redeemAccess($gameId)
    {
        $user = Auth::user();
        $game = Game::findOrFail($gameId);

        if (GameAccess::where('user_id', $user->id)->where('game_id', $gameId)->exists()) {
            $this->toast('Anda sudah memiliki akses game ini.', 'info');
            return;
        }

        if ($user->points < $game->points_required) {
            $this->toast('Poin Anda tidak mencukupi.', 'error');
            return;
        }

        app(PointsService::class)->redeemPoints($user, $game->points_required, 'Redeem akses game: ' . $game->name);

        GameAccess::create([
            'user_id' => $user->id,
            'game_id' => $game->id,
            'access_type' => 'full',
            'points_spent' => $game->points_required,
            'expires_at' => now()->addMonths(1),
        ]);

        $this->toast('Berhasil mendapatkan akses!', 'success');
    }

    public function render()
    {
        $games = Game::where('is_active', true)->get();
        $userAccess = GameAccess::where('user_id', Auth::id())->pluck('game_id')->toArray();

        return view('livewire.pages.sigame', [
            'games' => $games,
            'userAccess' => $userAccess,
            'userPoints' => Auth::user()->points ?? 0,
        ]);
    }
}