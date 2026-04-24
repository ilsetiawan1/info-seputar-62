<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'            => 'sometimes|required|string|max:255',
            'content'          => 'sometimes|required|string',
            'excerpt'          => 'nullable|string|max:500',
            'thumbnail'        => 'nullable|string|max:255',
            'category_id'      => 'sometimes|required|exists:categories,id',
            'author_id'        => 'sometimes|required|exists:users,id',
            'status'           => 'in:draft,review,published,archived',
            'published_at'     => 'nullable|date',
            'is_featured'      => 'boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'tags'             => 'nullable|array',
            'tags.*'           => 'exists:tags,id',
        ];
    }
}
