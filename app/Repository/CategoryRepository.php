<?php

declare(strict_types=1);

namespace App\Repository;

use App\Contracts\Repository\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function findAll(): Collection
    {
        return Category::all();
    }

    public function findAllWithPublishedPostsCount(): Collection
    {
        return Category::withCount([
            'posts' => fn ($query) => $query->where('is_published', true),
        ])->get();
    }
}
