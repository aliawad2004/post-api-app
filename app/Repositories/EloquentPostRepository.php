<?php

namespace App\Repositories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

class EloquentPostRepository implements PostRepositoryInterface
{
    public function all(): Collection
    {
        return Post::all();
    }

    public function find(int $id): ?Post
    {
        return Post::find($id);
    }

    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $post = Post::find($id);
        if ($post) {
            return $post->update($data);
        }
        return false;
    }

    public function delete(int $id): bool
    {
        $post = Post::find($id);
        if ($post) {
            return $post->delete();
        }
        return false;
    }
}