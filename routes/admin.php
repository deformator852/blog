<?php

use App\Http\Controllers\Admin\PostController;

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth'],
    'as' => 'admin.',
], static function () {
    Route::resource('posts', PostController::class);
});

Route::redirect('/admin', '/admin/posts')->name('admin.home');
