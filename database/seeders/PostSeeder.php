<!-- database\seeders\PostSeeder.php -->


<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $writers    = User::whereIn('role', ['writer', 'editor'])->get();
        $tags       = Tag::all();

        if ($writers->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('Pastikan UserSeeder dan CategorySeeder sudah dijalankan.');
            return;
        }

        // ── 25 artikel factory (published) ────────────────────
        Post::factory(25)->create([
            'status'       => 'published',
            'published_at' => now()->subDays(rand(1, 90)),
        ])->each(function ($post) use ($tags) {
            if ($tags->count() > 0) {
                $post->tags()->sync($tags->random(rand(1, 3))->pluck('id'));
            }
        });

        // ── 10 artikel draft / review ─────────────────────────
        Post::factory(10)->create([
            'status' => fn() => fake()->randomElement(['draft', 'review']),
        ]);

        // ── 3 artikel featured ────────────────────────────────
        Post::factory(3)->create([
            'status'       => 'published',
            'is_featured'  => true,
            'published_at' => now()->subDays(rand(1, 7)),
        ]);

        // ── 15 artikel manual (realistis, per kategori) ───────
        $this->seedManualPosts();
    }

    private function seedManualPosts(): void
    {
        // Ambil user yang sudah ada
        $admin  = User::where('email', 'admin@info62.com')->first();
        $editor = User::where('email', 'editor@info62.com')->first();
        $writer = User::where('email', 'penulis@info62.com')->first();

        // Fallback jika user tidak ditemukan
        $admin  = $admin  ?? User::where('role', 'admin')->first();
        $editor = $editor ?? User::where('role', 'editor')->first();
        $writer = $writer ?? User::where('role', 'writer')->first();

        $articles = [

            // ─── TEKNOLOGI ────────────────────────────────────
            [
                'category' => 'Teknologi',
                'author'   => $editor,
                'title'    => 'Indonesia Masuk 10 Besar Negara dengan Pertumbuhan AI Tercepat di Asia Tenggara',
                'excerpt'  => 'Laporan terbaru dari McKinsey Global Institute menempatkan Indonesia di posisi ke-7 dari negara-negara Asia Tenggara yang paling cepat mengadopsi teknologi kecerdasan buatan dalam sektor industri dan pemerintahan.',
                'content'  => '<p>Indonesia mencatat pertumbuhan yang signifikan dalam adopsi teknologi kecerdasan buatan (AI) di berbagai sektor. Laporan McKinsey Global Institute menempatkan Indonesia di posisi ke-7 di Asia Tenggara.</p><h2>Sektor yang Paling Cepat Berkembang</h2><p>Sektor perbankan, e-commerce, dan layanan kesehatan menjadi tiga industri yang paling agresif mengadopsi AI dalam dua tahun terakhir. Bank-bank besar Indonesia seperti BCA dan Mandiri sudah menggunakan AI untuk deteksi fraud dan layanan nasabah.</p><p>Pemerintah juga tidak ketinggalan. Program Satu Data Indonesia yang dicanangkan Presiden menjadi fondasi untuk pengembangan AI berbasis data pemerintahan yang lebih terintegrasi.</p><h2>Tantangan yang Masih Dihadapi</h2><p>Meski pertumbuhannya pesat, Indonesia masih menghadapi tantangan besar: kurangnya tenaga ahli AI lokal dan infrastruktur data yang belum merata di luar Jawa. Pemerintah menargetkan mencetak 100.000 talenta digital AI pada 2025.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=800&h=450&fit=crop&q=80',
                'tags'      => ['AI', 'Startup'],
                'is_featured' => true,
                'published_at' => now()->subDays(1),
            ],

            // ─── POLITIK ──────────────────────────────────────
            [
                'category' => 'Politik',
                'author'   => $admin,
                'title'    => 'KPU Tetapkan Jadwal Pilkada Serentak 2025, Ini Daftar Daerah yang Ikut',
                'excerpt'  => 'Komisi Pemilihan Umum (KPU) resmi menetapkan jadwal Pilkada Serentak 2025 yang akan diikuti oleh 37 provinsi dan 508 kabupaten/kota di seluruh Indonesia. Pendaftaran calon kepala daerah dibuka mulai Maret mendatang.',
                'content'  => '<p>Komisi Pemilihan Umum (KPU) RI secara resmi mengumumkan jadwal pelaksanaan Pemilihan Kepala Daerah (Pilkada) Serentak 2025 dalam rapat pleno terbuka yang digelar di Jakarta.</p><h2>Jadwal Lengkap Pilkada 2025</h2><p>Berdasarkan Peraturan KPU, tahapan Pilkada 2025 dimulai dengan pembentukan panitia pemilihan pada Januari, disusul pendaftaran pasangan calon pada Maret-April, kampanye pada Juli-September, dan pemungutan suara pada November 2025.</p><p>Sebanyak 37 provinsi akan menyelenggarakan pemilihan gubernur dan wakil gubernur, sementara 508 kabupaten/kota akan memilih bupati/walikota secara bersamaan.</p><h2>Antisipasi Kerawanan</h2><p>Badan Pengawas Pemilu (Bawaslu) memetakan sejumlah daerah rawan konflik yang perlu mendapat perhatian khusus, terutama di wilayah Papua dan Kalimantan Timur yang memiliki sejarah persaingan politik yang ketat.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1540910419892-4a36d2c3266c?w=800&h=450&fit=crop&q=80',
                'tags'      => ['Pilkada'],
                'is_featured' => false,
                'published_at' => now()->subDays(2),
            ],

            // ─── OLAHRAGA ─────────────────────────────────────
            [
                'category' => 'Olahraga',
                'author'   => $writer,
                'title'    => 'Timnas Indonesia U-23 Lolos ke Semifinal Piala Asia, Pecah Rekor Sejarah',
                'excerpt'  => 'Tim nasional sepak bola Indonesia U-23 berhasil menorehkan sejarah dengan lolos ke semifinal Piala Asia U-23 untuk pertama kalinya sepanjang sejarah. Garuda Muda mengalahkan Korea Selatan lewat drama adu penalti.',
                'content'  => '<p>Stadion Abdullah bin Khalifa, Qatar, menjadi saksi sejarah baru sepak bola Indonesia. Timnas U-23 berhasil mengalahkan Korea Selatan melalui adu penalti yang dramatis dengan skor 11-10.</p><h2>Perjalanan Garuda Muda</h2><p>Sepanjang turnamen, skuad asuhan Shin Tae-yong tampil konsisten. Dimulai dari kemenangan atas Irak di fase grup, lanjut ke babak 8 besar melawan Jepang yang berakhir lewat perpanjangan waktu, hingga puncaknya mengalahkan Korea Selatan.</p><p>Pemain naturalisasi Justin Hubner tampil sebagai pahlawan dengan mencetak gol penentu di babak adu penalti setelah kapten Rafael Struick mencetak gol di menit ke-87 untuk menyamakan kedudukan.</p><h2>Euforia Nasional</h2><p>Jutaan warga Indonesia begadang menyaksikan pertandingan yang berlangsung pukul 00.30 WIB ini. Tagar #IndonesiaBangga langsung trending nomor satu di berbagai platform media sosial.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?w=800&h=450&fit=crop&q=80',
                'tags'      => ['Timnas'],
                'is_featured' => true,
                'published_at' => now()->subDays(1),
            ],

            // ─── HIBURAN ──────────────────────────────────────
            [
                'category' => 'Hiburan',
                'author'   => $writer,
                'title'    => 'Film "Gundala 2" Resmi Tayang, Tiket Habis Terjual dalam 3 Jam',
                'excerpt'  => 'Film superhero Indonesia "Gundala 2" resmi tayang serentak di 500 layar bioskop seluruh Indonesia. Tiket untuk seminggu pertama habis terjual hanya dalam tiga jam setelah dibuka secara online.',
                'content'  => '<p>Jagat Sinema Bumilangit kembali menghadirkan film superhero terbaru yang paling ditunggu-tunggu: Gundala 2. Film ini tayang serentak di lebih dari 500 layar bioskop di 80 kota di Indonesia.</p><h2>Rekor Pra-Penjualan Tiket</h2><p>Sebelum tayang, Gundala 2 sudah memecahkan rekor pra-penjualan tiket film Indonesia. Lebih dari 200 ribu tiket terjual hanya dalam 24 jam pertama pembukaaan, melampaui rekor yang sebelumnya dipegang KKN di Desa Penari.</p><p>Iqbaal Ramadhan kembali memerankan Sancaka/Gundala dengan penampilan yang dinilai lebih matang dan emosional. Film ini juga memperkenalkan villain baru yang diperankan Ario Bayu.</p><h2>Kritik Positif</h2><p>Sejumlah pengamat film memberikan penilaian positif. Efek visual yang lebih canggih dan naskah yang lebih kuat menjadi keunggulan utama dibanding film pertamanya.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=800&h=450&fit=crop&q=80',
                'tags'      => ['Film'],
                'is_featured' => false,
                'published_at' => now()->subDays(3),
            ],

            // ─── BISNIS ───────────────────────────────────────
            [
                'category' => 'Bisnis',
                'author'   => $editor,
                'title'    => 'IHSG Tembus 8.000 Poin, Investor Asing Borong Saham Perbankan dan Energi',
                'excerpt'  => 'Indeks Harga Saham Gabungan (IHSG) menembus level psikologis 8.000 poin untuk pertama kalinya dalam sejarah bursa Indonesia, didorong oleh aksi beli masif investor asing di sektor perbankan dan energi terbarukan.',
                'content'  => '<p>Indeks Harga Saham Gabungan (IHSG) akhirnya berhasil menembus level psikologis 8.000 poin pada sesi perdagangan sore ini, menutup perdagangan di angka 8.043 poin atau naik 1,87% dari hari sebelumnya.</p><h2>Pemicu Kenaikan</h2><p>Kenaikan IHSG dipicu oleh beberapa faktor: keputusan The Fed yang menahan suku bunga, masuknya dana asing sebesar Rp 3,2 triliun dalam sepekan terakhir, serta laporan kinerja keuangan perbankan yang melampaui ekspektasi pasar.</p><p>Saham-saham big cap seperti BBCA, BMRI, dan TLKM menjadi motor penggerak utama. BBCA bahkan mencatat kenaikan 4,2% dalam sehari, nilai tertinggi dalam tiga bulan terakhir.</p><h2>Prospek ke Depan</h2><p>Analis dari Mandiri Sekuritas memperkirakan IHSG bisa menguji level 8.200-8.500 dalam 3-6 bulan ke depan jika kondisi global tetap kondusif dan laporan ekonomi Indonesia terus positif.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1611974789855-9c2a0a7236a3?w=800&h=450&fit=crop&q=80',
                'tags'      => ['IHSG', 'Investasi'],
                'is_featured' => false,
                'published_at' => now()->subDays(4),
            ],

            // ─── KESEHATAN ────────────────────────────────────
            [
                'category' => 'Kesehatan',
                'author'   => $writer,
                'title'    => 'Kemenkes Luncurkan Program Sarapan Bergizi Gratis untuk 10 Juta Anak SD',
                'excerpt'  => 'Kementerian Kesehatan bersama Kementerian Pendidikan resmi meluncurkan program sarapan bergizi gratis yang menyasar 10 juta siswa Sekolah Dasar di 34 provinsi. Program ini ditargetkan menekan angka stunting hingga 14% pada 2025.',
                'content'  => '<p>Pemerintah Indonesia meluncurkan program ambisius untuk mengatasi masalah gizi anak: Program Sarapan Bergizi Gratis yang akan menyasar 10 juta siswa SD di seluruh Indonesia mulai semester genap tahun ajaran ini.</p><h2>Menu Sarapan yang Disiapkan</h2><p>Setiap anak akan mendapatkan paket sarapan senilai Rp 15.000 per hari yang terdiri dari nasi atau umbi-umbian, lauk protein (telur/ikan/ayam), sayuran, dan susu. Menu dirancang oleh ahli gizi dari Universitas Indonesia dan IPB.</p><p>Total anggaran yang disiapkan pemerintah untuk program ini mencapai Rp 71 triliun per tahun, menjadikannya salah satu program gizi terbesar dalam sejarah Indonesia.</p><h2>Target Penurunan Stunting</h2><p>Indonesia saat ini masih mencatat angka stunting sebesar 21,5%. Dengan program ini, pemerintah menargetkan angka tersebut turun menjadi di bawah 14% pada akhir 2025, sesuai dengan target WHO untuk negara berkembang.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1567306226416-28f0efdc88ce?w=800&h=450&fit=crop&q=80',
                'tags'      => ['Gizi'],
                'is_featured' => false,
                'published_at' => now()->subDays(5),
            ],

            // ─── PENDIDIKAN ───────────────────────────────────
            [
                'category' => 'Pendidikan',
                'author'   => $editor,
                'title'    => 'Kemendikbud Hapus Sistem Zonasi PPDB, Diganti Seleksi Prestasi dan Afirmasi',
                'excerpt'  => 'Kementerian Pendidikan, Kebudayaan, Riset dan Teknologi secara resmi menghapus sistem zonasi dalam Penerimaan Peserta Didik Baru (PPDB) dan menggantinya dengan sistem seleksi berbasis prestasi akademik dan afirmasi sosial-ekonomi.',
                'content'  => '<p>Menteri Pendidikan mengumumkan perubahan mendasar dalam sistem PPDB yang selama ini menuai banyak kontroversi. Sistem zonasi yang berlaku sejak 2017 resmi dihapuskan dan diganti dengan pendekatan baru.</p><h2>Sistem Baru PPDB</h2><p>Sistem baru terdiri dari tiga jalur: jalur prestasi akademik (50% kuota), jalur afirmasi untuk keluarga kurang mampu dan penyandang disabilitas (30% kuota), dan jalur perpindahan tugas orang tua (20% kuota).</p><p>Penilaian prestasi tidak hanya dari nilai rapor, tetapi juga mencakup prestasi olahraga, seni, dan akademik tingkat kabupaten ke atas yang bisa diverifikasi melalui sertifikat resmi.</p><h2>Pro dan Kontra</h2><p>Kalangan akademisi dan LSM pendidikan terbagi pendapat. Sebagian menyambut positif karena dinilai lebih adil dan meritokratis, sementara sebagian lain khawatir sistem ini akan kembali menguntungkan keluarga mampu yang bisa membiayai les dan bimbingan belajar.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800&h=450&fit=crop&q=80',
                'tags'      => ['Pendidikan'],
                'is_featured' => false,
                'published_at' => now()->subDays(6),
            ],

            // ─── INTERNASIONAL ────────────────────────────────
            [
                'category' => 'Internasional',
                'author'   => $admin,
                'title'    => 'ASEAN Summit 2025 di Jakarta: Indonesia Pimpin Pembahasan Krisis Myanmar dan Laut China Selatan',
                'excerpt'  => 'Indonesia sebagai tuan rumah ASEAN Summit 2025 memimpin agenda pembahasan dua isu paling krusial di kawasan: krisis kemanusiaan Myanmar yang memasuki tahun keempat dan klaim tumpang tindih di Laut China Selatan.',
                'content'  => '<p>Jakarta menjadi pusat perhatian diplomatik dunia pekan ini dengan digelarnya ASEAN Summit 2025 yang dihadiri kepala negara dan pemerintahan dari 10 negara anggota ASEAN ditambah mitra dialog termasuk AS, China, Jepang, dan Korea Selatan.</p><h2>Isu Myanmar</h2><p>Krisis Myanmar yang sudah berlangsung empat tahun pasca-kudeta militer 2021 menjadi agenda utama. ASEAN kembali mendorong implementasi Lima Poin Konsensus yang hingga kini belum terlaksana, dengan tekanan agar junta militer Myanmar segera mengizinkan bantuan kemanusiaan masuk.</p><p>Indonesia mengusulkan mekanisme pengawasan baru dengan melibatkan PBB secara langsung, sebuah usulan yang mendapat dukungan dari Vietnam dan Filipina.</p><h2>Laut China Selatan</h2><p>Ketegangan antara China dan Filipina di Laut China Selatan kembali dibahas dengan serius. ASEAN menegaskan kembali pentingnya Code of Conduct yang mengikat secara hukum untuk mencegah eskalasi konflik lebih lanjut.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1529107386315-e1a2ed48a620?w=800&h=450&fit=crop&q=80',
                'tags'      => ['Breaking News'],
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ],

            // ─── TEKNOLOGI (2) ────────────────────────────────
            [
                'category' => 'Teknologi',
                'author'   => $writer,
                'title'    => 'Gojek dan Tokopedia Luncurkan Super App Terbaru dengan Fitur AI Asisten Pribadi',
                'excerpt'  => 'GoTo Group resmi meluncurkan versi terbaru aplikasi Gojek-Tokopedia yang terintegrasi dengan fitur AI asisten pribadi berbasis bahasa Indonesia. Asisten ini mampu membantu pengguna berbelanja, memesan layanan, hingga mengelola keuangan.',
                'content'  => '<p>GoTo Group mengambil langkah besar dalam persaingan super app Asia Tenggara dengan meluncurkan GoTo Assistant, sebuah AI asisten berbasis large language model (LLM) yang dioptimalkan khusus untuk pengguna Indonesia.</p><h2>Apa yang Bisa Dilakukan GoTo Assistant?</h2><p>GoTo Assistant mampu memahami perintah dalam Bahasa Indonesia dengan logat dan konteks lokal. Pengguna bisa meminta "carikan warung padang terdekat yang buka sekarang" atau "belikan aku powerbank dengan harga di bawah 200 ribu, rating bagus" dan asisten akan langsung memproses permintaan secara otomatis.</p><p>Integrasi dengan GoPay memungkinkan asisten untuk langsung melakukan transaksi dengan konfirmasi suara atau biometrik, tanpa perlu berpindah-pindah menu aplikasi.</p><h2>Persaingan dengan Grab</h2><p>Peluncuran ini dinilai sebagai respons langsung terhadap Grab yang bulan lalu mengumumkan kemitraan dengan OpenAI untuk menghadirkan ChatGPT ke dalam ekosistemnya di Singapura dan Malaysia.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=800&h=450&fit=crop&q=80',
                'tags'      => ['Startup', 'AI'],
                'is_featured' => false,
                'published_at' => now()->subDays(7),
            ],

            // ─── BISNIS (2) ───────────────────────────────────
            [
                'category' => 'Bisnis',
                'author'   => $editor,
                'title'    => 'Pertamina Geothermal Energy Ekspansi ke Filipina dan Vietnam, Nilai Investasi Rp 12 Triliun',
                'excerpt'  => 'PT Pertamina Geothermal Energy (PGE) mengumumkan ekspansi internasional perdananya ke Filipina dan Vietnam dengan total nilai investasi mencapai Rp 12 triliun. Ini menjadi langkah besar BUMN energi Indonesia go global.',
                'content'  => '<p>PT Pertamina Geothermal Energy (PGE), anak usaha Pertamina yang bergerak di bidang energi panas bumi, resmi mengumumkan ekspansi ke pasar internasional untuk pertama kalinya dalam sejarah perusahaan.</p><h2>Detail Proyek</h2><p>Di Filipina, PGE akan bermitra dengan Energy Development Corporation (EDC) untuk mengembangkan ladang panas bumi di Visayas dengan kapasitas 150 MW. Sementara di Vietnam, PGE akan membangun fasilitas geothermal pertama di negara tersebut di wilayah Da Lat, Lam Dong dengan kapasitas 100 MW.</p><p>Total investasi keduanya mencapai USD 750 juta atau sekitar Rp 12 triliun dengan target mulai beroperasi komersial pada 2027.</p><h2>Strategi BUMN Go Global</h2><p>Ekspansi PGE merupakan bagian dari roadmap pemerintah untuk menjadikan BUMN energi Indonesia sebagai pemain regional di sektor energi terbarukan, mengingat Indonesia memiliki 40% cadangan panas bumi dunia.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1473341304170-971dccb5ac1e?w=800&h=450&fit=crop&q=80',
                'tags'      => ['BUMN', 'Ekonomi'],
                'is_featured' => false,
                'published_at' => now()->subDays(8),
            ],

            // ─── POLITIK (2) ──────────────────────────────────
            [
                'category' => 'Politik',
                'author'   => $admin,
                'title'    => 'DPR Sahkan RUU Perlindungan Data Pribadi, Pelanggar Bisa Didenda Rp 50 Miliar',
                'excerpt'  => 'Dewan Perwakilan Rakyat (DPR) RI mengesahkan Rancangan Undang-Undang Perlindungan Data Pribadi dalam sidang paripurna. Perusahaan yang melanggar privasi data pengguna terancam denda hingga Rp 50 miliar atau 2% dari pendapatan tahunan.',
                'content'  => '<p>Setelah melalui pembahasan panjang selama lebih dari dua tahun, DPR RI akhirnya mengesahkan Undang-Undang Perlindungan Data Pribadi (UU PDP) dalam sidang paripurna yang berlangsung di Gedung DPR, Senayan.</p><h2>Poin-Poin Penting UU PDP</h2><p>UU ini mengatur hak subjek data untuk mengakses, mengoreksi, dan menghapus data pribadi mereka. Perusahaan wajib melaporkan kebocoran data dalam waktu 14 hari kerja kepada otoritas dan subjek data yang terdampak.</p><p>Sanksi bagi pelanggar berjenjang: teguran tertulis, denda administratif hingga 2% dari pendapatan tahunan atau maksimal Rp 50 miliar, hingga pencabutan izin usaha untuk pelanggaran berulang.</p><h2>Implementasi Bertahap</h2><p>Perusahaan diberikan masa transisi 2 tahun untuk menyesuaikan sistem pengelolaan datanya dengan ketentuan UU PDP. Badan Perlindungan Data Pribadi yang akan dibentuk bertugas mengawasi implementasinya.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=800&h=450&fit=crop&q=80',
                'tags'      => ['Hukum'],
                'is_featured' => false,
                'published_at' => now()->subDays(9),
            ],

            // ─── OLAHRAGA (2) ─────────────────────────────────
            [
                'category' => 'Olahraga',
                'author'   => $writer,
                'title'    => 'Kevin/Marcus Raih Gelar Juara All England 2025, Indonesia Kuasai Papan Atas Ganda Putra',
                'excerpt'  => 'Pasangan ganda putra Indonesia Kevin Sanjaya Sukamuljo dan Marcus Fernaldi Gideon berhasil meraih gelar juara All England 2025 setelah mengalahkan pasangan China dalam pertandingan final yang berlangsung dua gim.',
                'content'  => '<p>Kevin Sanjaya Sukamuljo dan Marcus Fernaldi Gideon kembali mengharumkan nama Indonesia di pentas bulu tangkis dunia. The Minions, julukan keduanya, berhasil meraih gelar juara All England 2025 dengan mengalahkan Liang Wei Keng/Wang Chang dari China.</p><h2>Perjalanan Menuju Final</h2><p>Perjalanan Kevin/Marcus menuju final terbilang mulus. Di babak perempat final, mereka mengalahkan pasangan Malaysia Lee Yang/Wang Chi-Lin dalam rubber game yang dramatis. Di semifinal, mereka memukul unggulan ketiga dari Denmark.</p><p>Final berlangsung sengit di dua gim dengan skor 21-19 dan 21-17. Kevin tampil dominan di net dengan refleks kilat yang menjadi trademark-nya.</p><h2>Dominasi Indonesia</h2><p>Dengan gelar ini, Indonesia mengukuhkan dominasi di sektor ganda putra dunia. Pasangan Indonesia kini menempati tiga dari lima peringkat teratas ranking dunia BWF.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?w=800&h=450&fit=crop&q=80',
                'tags'      => ['Bulu Tangkis'],
                'is_featured' => false,
                'published_at' => now()->subDays(10),
            ],

            // ─── HIBURAN (2) ──────────────────────────────────
            [
                'category' => 'Hiburan',
                'author'   => $editor,
                'title'    => 'Konser "Dewa 19 Reunion Tour" Jual 200 Ribu Tiket dalam 1 Hari, Pecah Rekor Indonesia',
                'excerpt'  => 'Konser reuni Dewa 19 yang dijadwalkan berlangsung di 10 kota besar Indonesia mencatat rekor penjualan tiket: 200 ribu tiket terjual hanya dalam satu hari setelah penjualan dibuka, memecahkan semua rekor konser musik di Indonesia.',
                'content'  => '<p>Demam Dewa 19 melanda Indonesia. Pengumuman Dewa 19 Reunion Tour yang mempertemukan kembali Ahmad Dhani dengan Once Mekel setelah bertahun-tahun berpisah menyedot antusiasme luar biasa dari para penggemar.</p><h2>Detail Tur</h2><p>Tur ini akan mampir di 10 kota: Jakarta (2 malam di GBK), Surabaya, Bandung, Medan, Makassar, Semarang, Yogyakarta, Bali, Palembang, dan Balikpapan. Total kapasitas 300 ribu penonton di seluruh kota.</p><p>Harga tiket berkisar dari Rp 350 ribu untuk tribun hingga Rp 3,5 juta untuk kategori VVIP. Meski begitu, semua kategori ludes terjual dalam hitungan jam.</p><h2>Setlist yang Dinantikan</h2><p>Ahmad Dhani mengonfirmasi bahwa tur ini akan membawakan 30 lagu hits Dewa 19 dari era 1993 hingga 2008, termasuk lagu-lagu yang belum pernah dibawakan live dalam satu dekade terakhir.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1470229722913-7c0e2dbbafd3?w=800&h=450&fit=crop&q=80',
                'tags'      => ['Musik'],
                'is_featured' => false,
                'published_at' => now()->subDays(11),
            ],

            // ─── KESEHATAN (2) ────────────────────────────────
            [
                'category' => 'Kesehatan',
                'author'   => $writer,
                'title'    => 'BPJS Kesehatan Tambah 2.000 Faskes Baru, Antrean Berobat Ditarget Turun 40 Persen',
                'excerpt'  => 'BPJS Kesehatan mengumumkan penambahan 2.000 fasilitas kesehatan tingkat pertama (FKTP) baru yang tersebar di 300 kabupaten/kota, dengan fokus pada daerah 3T (Tertinggal, Terdepan, Terluar) yang selama ini kesulitan mengakses layanan kesehatan.',
                'content'  => '<p>BPJS Kesehatan merealisasikan salah satu program transformasi layanan terbesarnya: penambahan 2.000 Fasilitas Kesehatan Tingkat Pertama (FKTP) baru secara serentak di seluruh Indonesia, dengan penekanan khusus pada daerah 3T.</p><h2>Sebaran Fasilitas Baru</h2><p>Dari 2.000 FKTP baru, sebanyak 800 di antaranya berlokasi di Papua, Papua Barat, Nusa Tenggara Timur, dan Maluku yang selama ini memiliki rasio dokter per penduduk terendah di Indonesia.</p><p>Selain klinik dan puskesmas, BPJS juga menambah jaringan dokter praktik mandiri yang terdaftar sebagai mitra FKTP, memperluas pilihan faskes bagi peserta JKN.</p><h2>Teknologi Antrean Digital</h2><p>Bersamaan dengan penambahan faskes, BPJS juga meluncurkan sistem antrean digital terintegrasi melalui aplikasi Mobile JKN. Peserta bisa mendaftar antrean dari rumah dan datang sesuai jadwal, menghindari antrean panjang yang selama ini menjadi keluhan utama.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1538108149393-fbbd81895907?w=800&h=450&fit=crop&q=80',
                'tags'      => ['Kesehatan'],
                'is_featured' => false,
                'published_at' => now()->subDays(12),
            ],

            // ─── INTERNASIONAL (2) ────────────────────────────
            [
                'category' => 'Internasional',
                'author'   => $admin,
                'title'    => 'Rupiah Menguat ke Rp 15.200 per Dolar AS, Terkuat dalam 18 Bulan Terakhir',
                'excerpt'  => 'Nilai tukar rupiah menguat signifikan ke level Rp 15.200 per dolar AS, menjadi yang terkuat dalam 18 bulan terakhir. Penguatan dipicu oleh keputusan The Fed menahan kenaikan suku bunga dan masuknya investasi asing ke obligasi pemerintah Indonesia.',
                'content'  => '<p>Rupiah mencatat penguatan yang signifikan terhadap dolar AS, menyentuh level Rp 15.200 per dolar di pasar spot Jakarta hari ini. Ini merupakan level terkuat rupiah sejak Oktober 2023.</p><h2>Faktor Penguatan Rupiah</h2><p>Penguatan rupiah didorong oleh beberapa faktor eksternal dan internal yang berjalan bersamaan. Dari sisi eksternal, keputusan The Fed untuk menahan suku bunga pada level 5,25-5,50% mendorong aliran modal kembali ke emerging markets termasuk Indonesia.</p><p>Dari dalam negeri, Kemenkeu mencatat inflow asing ke Surat Berharga Negara (SBN) sebesar Rp 28 triliun dalam sebulan terakhir, menunjukkan kepercayaan investor terhadap fundamental ekonomi Indonesia.</p><h2>Dampak ke Masyarakat</h2><p>Penguatan rupiah diperkirakan akan berdampak positif pada harga barang impor termasuk bahan baku industri dan BBM jenis tertentu. Bank Indonesia memperkirakan tekanan inflasi akan sedikit mereda dalam satu hingga dua bulan ke depan.</p>',
                'thumbnail' => 'https://images.unsplash.com/photo-1580519542036-c47de6196ba5?w=800&h=450&fit=crop&q=80',
                'tags'      => ['Ekonomi', 'Rupiah'],
                'is_featured' => false,
                'published_at' => now()->subDays(13),
            ],
        ];

        // ── Insert semua artikel ───────────────────────────────
        foreach ($articles as $data) {
            $category = Category::where('name', $data['category'])->first();
            if (!$category) continue;

            $slug = Str::slug($data['title']) . '-' . substr(md5($data['title']), 0, 6);

            // Skip jika sudah ada
            if (Post::where('slug', $slug)->exists()) continue;

            $post = Post::create([
                'title'        => $data['title'],
                'slug'         => $slug,
                'excerpt'      => $data['excerpt'],
                'content'      => $data['content'],
                'thumbnail'    => $data['thumbnail'],
                'category_id'  => $category->id,
                'author_id'    => $data['author']?->id ?? User::first()->id,
                'status'       => 'published',
                'is_featured'  => $data['is_featured'],
                'published_at' => $data['published_at'],
                'views_count'  => rand(1000, 45000),
                'meta_title'   => $data['title'],
                'meta_description' => $data['excerpt'],
            ]);

            // Attach tags
            if (!empty($data['tags'])) {
                $tagIds = Tag::whereIn('name', $data['tags'])->pluck('id');
                if ($tagIds->isNotEmpty()) {
                    $post->tags()->sync($tagIds);
                }
            }
        }

        $this->command->info('✅ 15 artikel manual berhasil ditambahkan.');
    }
}