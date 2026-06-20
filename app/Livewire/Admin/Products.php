<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\Product;
use App\Models\Genre;
use App\Services\FileUploadService;
use App\Traits\WithToast;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class Products extends Component {
    use WithPagination, WithFileUploads, WithToast;

    public $search = '';
    public $showModal = false;
    
    // Form fields
    public $productId;
    public $title, $author, $publisher, $isbn, $description, $price, $discount_price, $stock;
    public $genre_ids = [], $type = 'physical', $is_active = true, $is_featured = false;
    public $cover_image, $new_cover_image;

    public function render() {
        return view('livewire.admin.products', [
            'products' => Product::with('genres')
                            ->where('title', 'like', '%' . $this->search . '%')
                            ->latest()->paginate(10),
            'genres' => Genre::orderBy('name')->get()
        ]);
    }

    public function create() {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id) {
        $product = Product::findOrFail($id);
        $this->productId = $product->id;
        $this->title = $product->title;
        $this->author = $product->author;
        $this->publisher = $product->publisher;
        $this->isbn = $product->isbn;
        $this->description = $product->description;
        $this->price = $product->price;
        $this->discount_price = $product->discount_price;
        $this->stock = $product->stock;
        $this->genre_ids = $product->genres->pluck('id')->toArray();
        $this->type = $product->type;
        $this->is_active = $product->is_active;
        $this->is_featured = $product->is_featured;
        $this->cover_image = $product->cover_image;
        
        $this->showModal = true;
    }

    public function save(FileUploadService $fileService) {
        $this->validate([
            'title' => 'required',
            'genre_ids' => 'required|array|min:1',
            'price' => 'required|numeric',
            'author' => 'required',
            'description' => 'required'
        ]);

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'author' => $this->author,
            'publisher' => $this->publisher ?? 'Sigmaven Pub',
            'isbn' => $this->isbn,
            'description' => $this->description,
            'price' => $this->price,
            'discount_price' => $this->discount_price ?: null,
            'stock' => $this->stock ?? 0,
            'type' => $this->type,
            'is_active' => $this->is_active,
            'is_featured' => $this->is_featured,
        ];

        if ($this->new_cover_image) {
            if ($this->cover_image) {
                $fileService->deleteImage($this->cover_image);
            }
            $data['cover_image'] = $fileService->uploadImage($this->new_cover_image);
        }

        if ($this->productId) {
            $product = Product::find($this->productId);
            $product->update($data);
            $product->genres()->sync($this->genre_ids);
            $this->notify('Product updated!', 'success');
        } else {
            $product = Product::create($data);
            $product->genres()->sync($this->genre_ids);
            $this->notify('Product created!', 'success');
        }

        $this->showModal = false;
        $this->resetForm();
    }

    public function delete($id) {
        Product::find($id)->delete();
        $this->notify('Produk dihapus!', 'success');
    }

    private function resetForm() {
        $this->reset(['productId', 'title', 'author', 'publisher', 'isbn', 'description', 'price', 'discount_price', 'stock', 'genre_ids', 'type', 'is_active', 'is_featured', 'cover_image', 'new_cover_image']);
    }
}