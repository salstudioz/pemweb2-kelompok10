<?php
namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Game;
use App\Models\GameAccess;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class SigamePlay extends Component {
    public $game;

    public function mount($slug) {
        $this->game = Game::where('slug', $slug)->firstOrFail();
        
        $hasAccess = GameAccess::where('user_id', Auth::id())
                                ->where('game_id', $this->game->id)
                                ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('sigame')->with('error', 'Anda belum memiliki akses untuk game ini.');
        }
    }

    public function render() {
        return view('livewire.pages.sigame-play');
    }
}
