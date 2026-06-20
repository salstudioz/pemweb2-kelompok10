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
class Games extends Component {
    use WithPagination, WithFileUploads, WithToast;

    public $search = '';
    public $showModal = false;
    public $gameId;
    public $name, $description, $required_points, $is_active = true, $url;
    public $oldUrl;

    public function updatingSearch() {
        $this->resetPage();
    }

    public function create() {
        $this->resetInputFields();
        $this->showModal = true;
    }

    public function edit($id) {
        $game = Game::findOrFail($id);
        $this->gameId = $id;
        $this->name = $game->title;
        $this->description = $game->description;
        $this->required_points = $game->required_points;
        $this->is_active = $game->is_active;
        $this->oldUrl = $game->url;
        $this->showModal = true;
    }

    public function store() {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'required_points' => 'required|numeric',
            'is_active' => 'boolean',
            'url' => 'nullable|string',
        ]);

        $data = [
            'title' => $this->name,
            'description' => $this->description,
            'required_points' => $this->required_points,
            'is_active' => $this->is_active,
            'url' => $this->url ?? $this->oldUrl,
        ];

        Game::updateOrCreate(['id' => $this->gameId], $data);

        $this->notify($this->gameId ? 'Game diperbarui.' : 'Game ditambahkan.', 'success');
        $this->closeModal();
    }

    public function delete($id) {
        Game::findOrFail($id)->delete();
        $this->notify('Game dihapus.', 'success');
    }

    public function closeModal() {
        $this->showModal = false;
        $this->resetInputFields();
    }

    private function resetInputFields() {
        $this->gameId = null;
        $this->name = '';
        $this->description = '';
        $this->required_points = 0;
        $this->is_active = true;
        $this->url = null;
        $this->oldUrl = null;
    }

    public function render() {
        $games = Game::where('name', 'like', '%'.$this->search.'%')
                     ->orWhere('title', 'like', '%'.$this->search.'%') // In case the column is title
                     ->latest()
                     ->paginate(10);
        return view('livewire.admin.games', ['games' => $games]);
    }
}
