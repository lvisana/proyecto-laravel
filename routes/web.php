<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile/user/{id}', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/settings', [ProfileController::class, 'edit'])->name('settings.edit');
    Route::patch('/profile/settings', [ProfileController::class, 'update'])->name('settings.update');
    Route::delete('/profile/settings', [ProfileController::class, 'destroy'])->name('settings.destroy');
    Route::delete('/profile/settings', [ProfileController::class, 'destroy'])->name('settings.destroy');
    Route::get('/profile/avatar/{filename}', [ProfileController::class, 'avatar'])->name('profile.avatar');
    Route::get('profile/members/{search?}', [ProfileController::class, 'members'])->name('profile.members');


    Route::get('/image/file/{filename}', [ImageController::class, 'file'])->name('image.file');
    Route::get('/image/post/{id}', [ImageController::class, 'detail'])->name('image.detail');
    Route::get('/image/upload/{edit?}', [ImageController::class, 'create'])->name('image.create');
    Route::post('/image/save', [ImageController::class, 'save'])->name('image.save');
    Route::get('/image/likecount/{id}', [ImageController::class, 'likeCount'])->name('image.likeCount');
    Route::get('/image/delete/{id}', [ImageController::class, 'delete'])->name('image.delete');
    Route::post('/image/update/{id}', [ImageController::class, 'update'])->name('image.update');


    Route::get('/comment/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');
    Route::post('/comment/save', [CommentController::class, 'save'])->name('comment.save');


    Route::get('/like/save/{id}', [LikeController::class, 'like'])->name('like');
    Route::get('/like/favorite', [LikeController::class, 'favorite'])->name('like.favorite');

});

require __DIR__.'/auth.php';
