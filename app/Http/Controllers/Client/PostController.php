<?php

namespace App\Http\Controllers\Client;

use App\Contracts\Repository\PostRepositoryInterface;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class PostController extends Controller
{
    public function __construct(private readonly PostRepositoryInterface $postRepository) {}

    public function index()
    {
        //
    }

    public function show(int $id)
    {
        $post = $this->postRepository->findPublishedById($id);

        return Inertia::render('client/ShowPost', compact('post'));
    }
}
