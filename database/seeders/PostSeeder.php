<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

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

        // 25 artikel dengan status published
        Post::factory(25)->create([
            'status'       => 'published',
            'published_at' => now()->subDays(rand(1, 90)),
        ])->each(function ($post) use ($tags) {
            if ($tags->count() > 0) {
                $post->tags()->sync($tags->random(rand(1, 3))->pluck('id'));
            }
        });

        // 10 artikel draft / review
        Post::factory(10)->create([
            'status' => fn() => fake()->randomElement(['draft', 'review']),
        ]);

        // 3 artikel featured
        Post::factory(3)->create([
            'status'       => 'published',
            'is_featured'  => true,
            'published_at' => now()->subDays(rand(1, 7)),
        ]);
    }
}
