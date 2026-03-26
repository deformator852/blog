<?php

use App\Http\Controllers\Admin\PostController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth']
], function () {
    Route::get('/posts', [PostController::class, 'index'])->name('admin.posts.index');
});

Route::redirect('/admin', '/admin/posts')->name('admin.home');
