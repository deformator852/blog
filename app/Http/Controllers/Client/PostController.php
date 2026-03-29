<?php

namespace App\Http\Controllers\Client;

use App\Contracts\Repository\CategoryRepositoryInterface;
use App\Contracts\Repository\PostRepositoryInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
        private readonly CategoryRepositoryInterface $categoryRepository) {}

    public function index(Request $request): Response
    {
        $categorySlug = $request->query('category');

        $posts = $this->postRepository->findAllByCategoryPaginated($categorySlug);
        $categories = $this->categoryRepository->findAllWithPublishedPostsCount();

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
