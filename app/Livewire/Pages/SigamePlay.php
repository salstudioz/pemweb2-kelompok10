<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Game;

#[Layout('layouts.app')]
class SigamePlay extends Component
{
    public $game;

    public function mount($slug)
    {
        $this->game = Game::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.pages.sigame-play');
    }
}
