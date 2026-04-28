<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        $title = $this->faker->sentence;
        return [
            'title'        => $title,
            'slug'         => Str::slug($title) . '-' . $this->faker->unique()->numberBetween(1000, 9999),
            'excerpt'      => $this->faker->paragraph,
            'content'      => implode("\n\n", $this->faker->paragraphs(6)),
            'thumbnail'    => 'https://picsum.photos/seed/' . Str::slug(substr($title, 0, 20)) . '/800/600',
            'category_id'  => \App\Models\Category::inRandomOrder()->value('id') ?? Category::factory(),
            'author_id'    => \App\Models\User::inRandomOrder()->value('id') ?? User::factory(),
            'status'       => $this->faker->randomElement(['draft', 'review', 'published', 'archived']),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'is_featured'  => $this->faker->boolean(10),
            'views_count'  => $this->faker->numberBetween(0, 10000),
        ];
    }
}
