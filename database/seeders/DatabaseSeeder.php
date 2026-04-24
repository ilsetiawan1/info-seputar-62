<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Users ────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@info62.com'],
            [
                'name'     => 'Admin Utama',
                'password' => bcrypt('password'),
                'role'     => 'admin',
                'bio'      => 'Administrator portal Info Seputar +62.',
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'editor@info62.com'],
            [
                'name'     => 'Editor Senior',
                'password' => bcrypt('password'),
                'role'     => 'editor',
                'bio'      => 'Editor bertanggung jawab atas review konten.',
                'is_active' => true,
            ]
        );

        User::firstOrCreate(
            ['email' => 'penulis@info62.com'],
            [
                'name'     => 'Penulis Tamu',
                'password' => bcrypt('password'),
                'role'     => 'writer',
                'bio'      => 'Kontributor artikel seputar Indonesia.',
                'is_active' => true,
            ]
        );

        // 5 penulis acak tambahan
        User::factory(5)->create(['role' => 'writer']);

        // ─── Tags ─────────────────────────────────────
        $tagNames = [
            'Breaking News', 'Viral', 'Pilkada', 'BUMN',
            'Startup', 'AI', 'Kriminal', 'Ekonomi',
        ];
        foreach ($tagNames as $name) {
            Tag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
        }

        // ─── Kategori & Posts ─────────────────────────
        $this->call([
            CategorySeeder::class,
            PostSeeder::class,
        ]);
    }
}
