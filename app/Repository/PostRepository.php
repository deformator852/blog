<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contracts\Repository\PostRepositoryInterface;
use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
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
}
