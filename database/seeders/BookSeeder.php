<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Genre;
use Illuminate\Support\Str;

class BookSeeder extends Seeder {
    public function run(): void {
        // Daftar genre yang valid dari GenreSeeder
        $validGenres = [
            'Adventure', 'Ballads', "Children's tale", 'Classic', 'Comic', 'Crime',
            'Detective', 'Drama', 'Fable', 'Fairy tale', 'Fantasy', 'Folklore',
            'Graphic novel', 'History', 'Horror', 'Legends', 'Love story', 'Lyrics',
            'Mystery', 'Mythology', 'Poetry', 'Religion', 'Romance', 'Science',
            'Science fiction', 'Sonnet', 'Technical', 'Thriller', 'Tragedy', 'Biography'
        ];

        // 45 buku dengan genre yang valid
        $books = [];
        
        // Buku 1-15: Fiksi Indonesia
        for ($i = 1; $i <= 15; $i++) {
            $books[] = [
                'title' => "Buku Indonesia {$i}: " . $this->getIndonesianTitle($i),
                'author' => $this->getIndonesianAuthor($i),
                'description' => $this->getDescription($i, 'indonesia'),
                'price' => rand(60000, 120000),
                'discount_price' => rand(0, 1) ? rand(50000, 100000) : null,
                'stock' => rand(50, 300),
                'type' => 'physical',
                'publisher' => $this->getPublisher($i),
                'isbn' => '978-' . rand(100, 999) . '-' . rand(10000, 99999) . '-' . rand(0, 9) . '-' . rand(0, 9),
                'cover_image' => 'books/book-' . $i . '.jpg',
                'genres' => $this->getRandomGenres($validGenres, 3),
            ];
        }
        
        // Buku 16-30: Fiksi Internasional
        for ($i = 16; $i <= 30; $i++) {
            $books[] = [
                'title' => "International Book {$i}: " . $this->getInternationalTitle($i),
                'author' => $this->getInternationalAuthor($i),
                'description' => $this->getDescription($i, 'international'),
                'price' => rand(70000, 150000),
                'discount_price' => rand(0, 1) ? rand(60000, 130000) : null,
                'stock' => rand(40, 250),
                'type' => 'physical',
                'publisher' => $this->getInternationalPublisher($i),
                'isbn' => '978-' . rand(100, 999) . '-' . rand(10000, 99999) . '-' . rand(0, 9) . '-' . rand(0, 9),
                'cover_image' => 'books/book-' . $i . '.jpg',
                'genres' => $this->getRandomGenres($validGenres, 3),
            ];
        }
        
        // Buku 31-45: Non-Fiksi & Digital
        for ($i = 31; $i <= 45; $i++) {
            $isDigital = $i > 40;
            $books[] = [
                'title' => ($isDigital ? "Digital Book " : "Non-Fiction Book ") . ($i - 30) . ": " . $this->getNonFictionTitle($i),
                'author' => $this->getNonFictionAuthor($i),
                'description' => $this->getDescription($i, 'nonfiction'),
                'price' => rand(80000, 180000),
                'discount_price' => rand(0, 1) ? rand(70000, 160000) : null,
                'stock' => $isDigital ? 0 : rand(30, 200),
                'type' => $isDigital ? 'digital' : 'physical',
                'publisher' => $this->getNonFictionPublisher($i),
                'isbn' => '978-' . rand(100, 999) . '-' . rand(10000, 99999) . '-' . rand(0, 9) . '-' . rand(0, 9),
                'cover_image' => 'books/book-' . $i . '.jpg',
                'genres' => $this->getRandomGenres($validGenres, 3, $isDigital),
            ];
        }
        
        foreach ($books as $bookData) {
            // Cek apakah buku sudah ada berdasarkan ISBN
            $existingBook = Product::where('isbn', $bookData['isbn'])->first();
            
            if (!$existingBook) {
                $book = Product::create([
                    'title' => $bookData['title'],
                    'slug' => Str::slug($bookData['title']),
                    'author' => $bookData['author'],
                    'description' => $bookData['description'],
                    'price' => $bookData['price'],
                    'discount_price' => $bookData['discount_price'],
                    'stock' => $bookData['stock'],
                    'type' => $bookData['type'],
                    'publisher' => $bookData['publisher'],
                    'isbn' => $bookData['isbn'],
                    'cover_image' => $bookData['cover_image'],
                    'is_active' => true,
                    'is_featured' => rand(0, 4) === 0, // 20% chance to be featured
                ]);
                
                // Attach genres
                foreach ($bookData['genres'] as $genreName) {
                    $genre = Genre::where('name', $genreName)->first();
                    if ($genre) {
                        $book->genres()->attach($genre->id);
                    }
                }
            }
        }
        
        $this->command->info('45 books seeded successfully with valid genres from GenreSeeder!');
    }
    
    private function getRandomGenres($validGenres, $count = 3, $isDigital = false) {
        $availableGenres = $validGenres;
        
        // Jika digital, prioritaskan genre tertentu
        if ($isDigital) {
            $digitalPreferred = ['Technical', 'Science', 'Self-Help', 'Business'];
            $availableGenres = array_merge($digitalPreferred, $availableGenres);
        }
        
        shuffle($availableGenres);
        return array_slice($availableGenres, 0, $count);
    }
    
    private function getIndonesianTitle($index) {
        $titles = [
            'Laskar Pelangi', 'Bumi Manusia', 'Pulang', 'Dilan 1990', 'Hujan',
            'Rindu', 'Perahu Kertas', 'Supernova', 'Negeri 5 Menara', 'Ayat-Ayat Cinta',
            'Cantik Itu Luka', 'Saman', 'Laut Bercerita', 'Anak Bajang Menggiring Angin', 'Sepotong Senja'
        ];
        return $titles[($index - 1) % count($titles)];
    }
    
    private function getInternationalTitle($index) {
        $titles = [
            'The Alchemist', '1984', 'To Kill a Mockingbird', 'Pride and Prejudice', 'The Great Gatsby',
            'Harry Potter', 'The Hobbit', 'Lord of the Rings', 'Catcher in the Rye', 'Da Vinci Code',
            'Hunger Games', 'Girl on the Train', 'Gone Girl', 'The Shining', 'It'
        ];
        return $titles[($index - 16) % count($titles)];
    }
    
    private function getNonFictionTitle($index) {
        $titles = [
            'Atomic Habits', 'Psychology of Money', 'Rich Dad Poor Dad', 'Sapiens', 'Thinking Fast and Slow',
            'Subtle Art', 'Deep Work', 'Start With Why', '7 Habits', 'Win Friends',
            'Power of Now', 'Man\'s Search', 'Four Agreements', 'Midnight Library', 'Educated'
        ];
        return $titles[($index - 31) % count($titles)];
    }
    
    private function getIndonesianAuthor($index) {
        $authors = [
            'Andrea Hirata', 'Pramoedya Ananta Toer', 'Tere Liye', 'Pidi Baiq', 'Tere Liye',
            'Tere Liye', 'Dee Lestari', 'Dee Lestari', 'Ahmad Fuadi', 'Habiburrahman El Shirazy',
            'Eka Kurniawan', 'Ayu Utami', 'Leila S. Chudori', 'Sindhunata', 'Seno Gumira Ajidarma'
        ];
        return $authors[($index - 1) % count($authors)];
    }
    
    private function getInternationalAuthor($index) {
        $authors = [
            'Paulo Coelho', 'George Orwell', 'Harper Lee', 'Jane Austen', 'F. Scott Fitzgerald',
            'J.K. Rowling', 'J.R.R. Tolkien', 'J.R.R. Tolkien', 'J.D. Salinger', 'Dan Brown',
            'Suzanne Collins', 'Paula Hawkins', 'Gillian Flynn', 'Stephen King', 'Stephen King'
        ];
        return $authors[($index - 16) % count($authors)];
    }
    
    private function getNonFictionAuthor($index) {
        $authors = [
            'James Clear', 'Morgan Housel', 'Robert Kiyosaki', 'Yuval Harari', 'Daniel Kahneman',
            'Mark Manson', 'Cal Newport', 'Simon Sinek', 'Stephen Covey', 'Dale Carnegie',
            'Eckhart Tolle', 'Viktor Frankl', 'Don Miguel Ruiz', 'Matt Haig', 'Tara Westover'
        ];
        return $authors[($index - 31) % count($authors)];
    }
    
    private function getDescription($index, $type) {
        $descriptions = [
            'indonesia' => [
                'Kisah inspiratif tentang perjuangan dan semangat pantang menyerah.',
                'Novel yang menggambarkan kehidupan dengan segala kompleksitasnya.',
                'Kisah cinta dan pengorbanan yang menyentuh hati.',
                'Petualangan yang penuh dengan makna dan pelajaran hidup.',
                'Karya sastra yang mendalam tentang identitas dan perjuangan.'
            ],
            'international' => [
                'A timeless classic that explores the human condition.',
                'An epic adventure that captivates readers of all ages.',
                'A thrilling mystery that keeps you on the edge of your seat.',
                'A profound exploration of society and human nature.',
                'A masterpiece of literature that transcends time and culture.'
            ],
            'nonfiction' => [
                'Practical guide for personal and professional development.',
                'Insightful analysis of human behavior and decision making.',
                'Transformative principles for achieving success and fulfillment.',
                'Comprehensive exploration of historical and scientific concepts.',
                'Evidence-based strategies for improving productivity and well-being.'
            ]
        ];
        
        $descList = $descriptions[$type];
        return $descList[$index % count($descList)] . " Buku ini telah menerima banyak penghargaan dan diapresiasi oleh pembaca di seluruh dunia.";
    }
    
    private function getPublisher($index) {
        $publishers = ['Gramedia', 'Bentang Pustaka', 'Mizan', 'Kepustakaan Populer Gramedia', 'Pastel Books'];
        return $publishers[$index % count($publishers)];
    }
    
    private function getInternationalPublisher($index) {
        $publishers = ['Penguin', 'HarperCollins', 'Random House', 'Simon & Schuster', 'Macmillan'];
        return $publishers[$index % count($publishers)];
    }
    
    private function getNonFictionPublisher($index) {
        $publishers = ['Portfolio', 'Harvard Business Review', 'Penguin Press', 'Basic Books', 'Wiley'];
        return $publishers[$index % count($publishers)];
    }
}