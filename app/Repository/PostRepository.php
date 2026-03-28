<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contracts\Repository\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PostRepository implements PostRepositoryInterface
{
    public function create(array $data, UploadedFile $image): Post
    {
        $path = $image->store('posts', 'public');
        $data['image_path'] = $path;

        try {
            return Post::create($data);
        } catch (Throwable $e) {
            if ($path && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
            throw $e;
        }
    }

    public function findAllPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Post::query()->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function delete(Post $post): void
    {
        $post->delete();
    }

    public function update(Post $post, array $data = [], ?UploadedFile $image = null): Post
    {
        $oldPath = null;

        if ($image) {
            $path = $image->store('posts', 'public');
            $oldPath = $post->image_path;
            $data['image_path'] = $path;
        }

        try {
            $post->update($data);

            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }

            return $post->fresh();
        } catch (Throwable $e) {
            if ($image && isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            throw $e;
        }
    }

    public function findPublishedById(int $id): Post
    {
        return Post::with('category')->where('id', $id)->where('is_published', true)->firstOrFail();
    }
}
