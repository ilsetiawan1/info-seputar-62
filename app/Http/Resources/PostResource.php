<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'slug'             => $this->slug,
            'excerpt'          => $this->excerpt,
            'content'          => $this->when($request->routeIs('posts.show'), $this->content),
            'thumbnail'        => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'status'           => $this->status,
            'is_featured'      => $this->is_featured,
            'views_count'      => $this->views_count,
            'published_at'     => $this->published_at?->toIso8601String(),
            'meta_title'       => $this->meta_title,
            'meta_description' => $this->meta_description,
            'category'         => new CategoryResource($this->whenLoaded('category')),
            'author'           => [
                'id'     => $this->author?->id,
                'name'   => $this->author?->name,
                'avatar' => $this->author?->avatar,
            ],
            'tags'             => $this->whenLoaded('tags', fn() => $this->tags->map(fn($t) => [
                'id'   => $t->id,
                'name' => $t->name,
                'slug' => $t->slug,
            ])),
            'created_at'       => $this->created_at?->toIso8601String(),
            'updated_at'       => $this->updated_at?->toIso8601String(),
        ];
    }
}
