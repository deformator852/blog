<?php

declare(strict_types=1);

namespace App\Contracts\Repository;

use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

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
}
