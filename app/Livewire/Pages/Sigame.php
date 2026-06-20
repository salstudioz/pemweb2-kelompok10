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
class Sigame extends Component {
    use WithToast;

    public function redeemAccess($gameId, PointsService $ptsService) {
        $game = Game::findOrFail($gameId);
        
        if (GameAccess::where('user_id', Auth::id())->where('game_id', $gameId)->exists()) {
            $this->notify('Anda sudah memiliki akses game ini.', 'info');
            return;
        }

        try {
            $ptsService->redeemPoints(Auth::user(), $game->required_points, 'Redeem akses game: ' . $game->title);
            GameAccess::create(['user_id' => Auth::id(), 'game_id' => $game->id]);
            $this->notify('Berhasil mendapatkan akses!', 'success');
        } catch (\Exception $e) {
            $this->notify($e->getMessage(), 'error');
        }
    }

    public function render() {
        $games = Game::where('is_active', true)->get();
        $userAccess = GameAccess::where('user_id', Auth::id())->pluck('game_id')->toArray();
        
        return view('livewire.pages.sigame', [
            'games' => $games,
            'userAccess' => $userAccess,
            'userPoints' => Auth::user()->points
        ]);
    }
}