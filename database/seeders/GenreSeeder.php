<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Genre;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            'Adventure', 'Ballads', "Children's tale", 'Classic', 'Comic', 'Crime',
            'Detective', 'Drama', 'Fable', 'Fairy tale', 'Fantasy', 'Folklore',
            'Graphic novel', 'History', 'Horror', 'Legends', 'Love story', 'Lyrics',
            'Mystery', 'Mythology', 'Poetry', 'Religion', 'Romance', 'Science',
            'Science fiction', 'Sonnet', 'Technical', 'Thriller', 'Tragedy',
            'Biography'  // Ditambahkan untuk menjadi 30 genre
        ];

        foreach ($genres as $genre) {
            Genre::firstOrCreate([
                'name' => $genre
            ], [
                'slug' => Str::slug($genre),
                'image_url' => 'https://ui-avatars.com/api/?name=' . urlencode($genre) . '&background=random&size=400&font-size=0.33',
            ]);
        }
    }
}
