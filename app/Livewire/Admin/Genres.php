<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Genre;
use Illuminate\Support\Str;
use App\Traits\WithToast;

#[Layout('layouts.admin')]
class Genres extends Component
{
    use WithPagination, WithFileUploads, WithToast;

    public $search = '';
    public $showModal = false;
    public $genreId, $name, $image;
    public $oldImage;

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
        $genre = Genre::findOrFail($id);
        $this->genreId = $id;
        $this->name = $genre->name;
        $this->oldImage = $genre->image_url;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->name),
        ];

        if ($this->image) {
            $data['image_url'] = '/storage/' . $this->image->store('genres', 'public');
        } elseif (!$this->oldImage && !$this->genreId) {
            $data['image_url'] = 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random&size=400&font-size=0.33';
        }

        Genre::updateOrCreate(['id' => $this->genreId], $data);

        $this->notify($this->genreId ? 'Genre updated.' : 'Genre added.', 'success');
        $this->closeModal();
    }

    public function delete($id)
    {
        Genre::findOrFail($id)->delete();
        $this->notify('Genre deleted.', 'success');
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->genreId = null;
        $this->name = '';
        $this->image = null;
        $this->oldImage = null;
    }

    public function render()
    {
        $genres = Genre::when($this->search, function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
        })->latest()->paginate(10);

        return view('livewire.admin.genres', compact('genres'));
    }
}
