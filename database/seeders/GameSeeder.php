<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\GameAccess;
use App\Models\User;

class GameSeeder extends Seeder {
    public function run(): void {
        $games = [
            [
                'title'           => 'Word Quest',
                'description'     => 'Tantang kemampuan kosakata kamu! Susun kata-kata dari huruf acak sebanyak mungkin dalam waktu yang ditentukan. Cocok untuk semua usia dan melatih daya ingat.',
                'required_points' => 0,
                'url'             => 'https://wordquest.sigmaven.com',
                'is_active'       => true,
            ],
            [
                'title'           => 'Book Trivia',
                'description'     => 'Uji pengetahuan literasimu! Jawab pertanyaan seputar buku-buku populer dunia dan Indonesia. Dapatkan poin ekstra untuk setiap jawaban benar.',
                'required_points' => 500,
                'url'             => 'https://trivia.sigmaven.com',
                'is_active'       => true,
            ],
            [
                'title'           => 'Story Builder',
                'description'     => 'Bangun cerita pendek bersama pemain lain secara interaktif. Setiap giliran kamu menambahkan satu kalimat. Kembangkan imajinasimu dan ciptakan cerita yang unik!',
                'required_points' => 1000,
                'url'             => 'https://storybuilder.sigmaven.com',
                'is_active'       => true,
            ],
            [
                'title'           => 'Author Hunt',
                'description'     => 'Diberikan sebuah kutipan buku, tebak siapa pengarangnya! Ratusan kutipan dari penulis terkenal dunia menanti kamu. Semakin banyak kamu membaca, semakin mudah memenangkannya.',
                'required_points' => 1500,
                'url'             => 'https://authorhunt.sigmaven.com',
                'is_active'       => true,
            ],
            [
                'title'           => 'Genre Puzzle',
                'description'     => 'Cocokkan judul buku dengan genre yang tepat dalam waktu 60 detik. Game seru yang menguji seberapa luas pengetahuan literasimu tentang berbagai genre buku.',
                'required_points' => 2000,
                'url'             => 'https://genrepuzzle.sigmaven.com',
                'is_active'       => true,
            ],
            [
                'title'           => 'Reading Speed Challenge',
                'description'     => 'Uji kecepatan dan pemahaman membacamu! Baca sebuah teks pendek lalu jawab pertanyaan terkait isinya. Cocok untuk melatih kemampuan speed reading.',
                'required_points' => 3000,
                'url'             => 'https://speedread.sigmaven.com',
                'is_active'       => true,
            ],
            [
                'title'           => 'Literary Crossword',
                'description'     => 'Teka-teki silang bertema sastra dan literasi. Semua clue berhubungan dengan tokoh, judul buku, dan istilah sastra. Level kesulitan meningkat setiap harinya.',
                'required_points' => 2500,
                'url'             => 'https://crossword.sigmaven.com',
                'is_active'       => true,
            ],
            [
                'title'           => 'Plot Twist',
                'description'     => 'Game eksklusif untuk member setia Sigmaven! Prediksi akhir cerita dari berbagai sinopsis buku yang diberikan. Gunakan logikamu untuk mengungkap plot twist terbaik.',
                'required_points' => 5000,
                'url'             => 'https://plottwist.sigmaven.com',
                'is_active'       => true,
            ],
            [
                'title'           => 'Book Cover Guess',
                'description'     => 'Ditampilkan cover buku yang disamarkan, tebak judulnya sebelum waktu habis! Tersedia ribuan cover buku dari berbagai negara dan era.',
                'required_points' => 0,
                'url'             => 'https://coverguess.sigmaven.com',
                'is_active'       => true,
            ],
            [
                'title'           => 'Literature Master',
                'description'     => 'Game premium paling eksklusif di Sigmaven! Kompetisi mingguan antar pembaca terbaik dengan hadiah berupa voucher pembelian buku senilai ratusan ribu rupiah.',
                'required_points' => 8000,
                'url'             => 'https://litmaster.sigmaven.com',
                'is_active'       => false, // coming soon
            ],
        ];

        foreach ($games as $gameData) {
            Game::firstOrCreate(
                ['title' => $gameData['title']],
                $gameData
            );
        }

        // Berikan akses game gratis ke semua user
        $freeGames = Game::where('required_points', 0)->get();
        $allUsers  = User::all();

        foreach ($allUsers as $user) {
            foreach ($freeGames as $game) {
                GameAccess::firstOrCreate([
                    'user_id' => $user->id,
                    'game_id' => $game->id,
                ]);
            }
        }

        // Berikan akses game berbayar ke user dengan cukup poin
        $paidGames = Game::where('required_points', '>', 0)->get();

        foreach ($allUsers as $user) {
            foreach ($paidGames as $game) {
                if ($user->points >= $game->required_points) {
                    GameAccess::firstOrCreate([
                        'user_id' => $user->id,
                        'game_id' => $game->id,
                    ]);
                }
            }
        }

        $this->command->info('Games seeded successfully! (' . count($games) . ' games, access assigned based on user points)');
    }
}
