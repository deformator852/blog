<?php

declare(strict_types=1);

namespace App\Contracts\Repository;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

interface PostRepositoryInterface
{
    /**
     * @param array{
     *     category_id: int,
     *     title: string,
     *     content: string,
     *     is_published: bool
     * } $data
     */
    public function create(array $data, UploadedFile $image): Post;

    public function findAllPaginated(int $perPage = 10): LengthAwarePaginator;

    public function delete(Post $post): void;

    /**
     * @param array{
     *     category_id?: int,
     *     title?: string,
     *     content?: string,
     *     is_published?: bool
     * } $data
     */
    public function update(Post $post, array $data = [], ?UploadedFile $image = null): Post;

    public function findPublishedById(int $id): Post;
}
