<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repository\PostRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function __construct(private readonly PostRepositoryInterface $postRepository)
    {
    }

    public function index(): Response
    {
        $posts = $this->postRepository->findAllPaginated();
        return Inertia::render('admin/PostsList', compact('posts'));
    }

    public function create(): Response
    {
        $categories = Category::all();
        return Inertia::render('admin/CreatePost', compact('categories'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $image = $request->file('image_path');

        $this->postRepository->create($data, $image);

        return redirect()->route('admin.posts.index');
    }
}
