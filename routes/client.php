<?php

use App\Http\Controllers\Client\PostController;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::get('/posts/{id}', [PostController::class, 'show'])->name('client.posts.show');
