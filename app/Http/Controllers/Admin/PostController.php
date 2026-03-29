<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Repository\PostRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class PostController extends Controller
{
    public function __construct(private readonly PostRepositoryInterface $postRepository) {}

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

        try {
            $this->postRepository->create($data, $image);

            return redirect()->route('admin.posts.index')
                ->with('success', 'Post created successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('admin.posts.index')
                ->with('error', 'Failed to create post');
        }
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();
        $image = $request->file('image_path');
        try {
            $this->postRepository->update($post, $data, $image);

            return redirect()->route('admin.posts.index')
                ->with('success', 'Post updated successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('admin.posts.edit', $post)
                ->with('error', 'Failed to update post.');
        }
    }

    public function edit(Post $post): Response
    {
        $categories = Category::all();

        return Inertia::render('admin/EditPost', compact('post', 'categories'));
    }

    public function destroy(Post $post): RedirectResponse
    {
        try {
            $this->postRepository->delete($post);

            return redirect()->route('admin.posts.index')
                ->with('success', 'Post deleted successfully.');
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return redirect()->route('admin.posts.index')
                ->with('error', 'Failed to delete post.');
        }
    }
}
