<?php

use App\Http\Controllers\Client\PostController;

Route::get('/', [PostController::class, 'index'])->name('client.posts.index');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('client.posts.show');
