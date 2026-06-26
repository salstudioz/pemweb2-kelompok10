<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Game;
use Illuminate\Support\Str;
use App\Traits\WithToast;

#[Layout('layouts.admin')]
class Games extends Component
{
    use WithPagination, WithFileUploads, WithToast;

    public $search = '';
    public $showModal = false;
    public $gameId;
    public $name;
    public $description;
    public $required_points; 
    public $is_active = true;
    public $thumbnail;
    public $oldThumbnail;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $game = Game::findOrFail($id);
        $this->gameId = $id;
        $this->name = $game->name;
        $this->description = $game->description;
        $this->required_points = $game->points_required;
        $this->is_active = $game->is_active;
        $this->oldThumbnail = $game->thumbnail;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'required_points' => 'required|numeric|min:0',
            'is_active' => 'boolean',
            'thumbnail' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'required_points' => $this->required_points,
            'is_active' => $this->is_active,
            'slug' => Str::slug($this->name),
        ];

        if ($this->thumbnail) {
            if ($this->oldThumbnail && \Storage::disk('public')->exists($this->oldThumbnail)) {
                \Storage::disk('public')->delete($this->oldThumbnail);
            }
            $path = $this->thumbnail->store('games', 'public');
            $data['thumbnail'] = $path;
        } elseif ($this->oldThumbnail) {
            $data['thumbnail'] = $this->oldThumbnail;
        }

        Game::updateOrCreate(['id' => $this->gameId], $data);

        $this->toast($this->gameId ? 'Game diperbarui.' : 'Game ditambahkan.', 'success');
        $this->closeModal();
    }

    public function delete($id)
    {
        $game = Game::findOrFail($id);
        if ($game->thumbnail && \Storage::disk('public')->exists($game->thumbnail)) {
            \Storage::disk('public')->delete($game->thumbnail);
        }
        $game->delete();
        $this->toast('Game dihapus.', 'success');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->gameId = null;
        $this->name = '';
        $this->description = '';
        $this->required_points = 0;
        $this->is_active = true;
        $this->thumbnail = null;
        $this->oldThumbnail = null;
    }

    public function render()
    {
        $games = Game::where('name', 'like', '%' . $this->search . '%')
                     ->orWhere('description', 'like', '%' . $this->search . '%')
                     ->latest()
                     ->paginate(10);
        return view('livewire.admin.games', ['games' => $games]);
    }
}
