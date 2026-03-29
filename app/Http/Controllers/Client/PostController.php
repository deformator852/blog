<?php

namespace App\Http\Controllers\Client;

use App\Contracts\Repository\PostRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function __construct(private readonly PostRepositoryInterface $postRepository) {}

    public function index(Request $request): Response
    {
        $categorySlug = $request->query('category');

        $posts = $this->postRepository->findAllByCategoryPaginated($categorySlug);

        $categories = Category::withCount([
            'posts' => fn ($q) => $q->where('is_published', true),
        ])->get();

        return Inertia::render('client/Home', [
            'posts' => $posts,
            'categories' => $categories,
            'activeCategory' => $categorySlug,
        ]);
    }

    public function show(int $id)
    {
        $post = $this->postRepository->findPublishedById($id);

        return Inertia::render('client/ShowPost', compact('post'));
    }
}
