<?php

use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::group(['prefix' => '/api'], function () {
    Route::post('/upload-profile-picture', [ProfileController::class, 'uploadImage']);
    Route::get('/get-profile-picture', [ProfileController::class, 'getImage']);
    Route::get('/get-user-posts', [PostsController::class, 'getPosts'])->middleware('my-auth');
    Route::post('/create-post', [PostsController::class, 'createPost']);
    Route::delete('/delete-post/{id}', [PostsController::class, 'deletePost']);
    Route::put('/post/{id}', [PostsController::class, 'updatePost']);
    Route::post('/posts/{id}/toggle-like', [PostsController::class, 'toggleLike']);
    Route::get('/me/posts/liked', [PostsController::class, 'getLikedPosts']);
    Route::get('/all-posts', [PostsController::class, 'getAllPosts']);
});

