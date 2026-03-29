<?php

declare(strict_types=1);

namespace App\Contracts\Repository;

use App\Models\Category;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface
{
    /**
     * @return Collection<int, Category>
     */
    public function findAll(): Collection;

    /**
     * @return Collection<int, Category>
     */
    public function findAllWithPublishedPostsCount(): Collection;
}
