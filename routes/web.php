<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
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
Route::get('/', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/avatar/{filename}', [ProfileController::class, 'avatar'])->name('profile.avatar');


    Route::get('/image/file/{filename}', [ImageController::class, 'file'])->name('image.file');
    Route::get('/image/post/{id}', [ImageController::class, 'detail'])->name('image.detail');

    Route::get('/image/upload', [ImageController::class, 'create'])->name('image.create');
    Route::post('/image/save', [ImageController::class, 'save'])->name('image.save');


    Route::get('/comment/delete/{id}', [CommentController::class, 'delete'])->name('comment.delete');
    Route::post('/comment/save', [CommentController::class, 'save'])->name('comment.save');


    Route::get('/like/{id}', [LikeController::class, 'like'])->name('like');
});

require __DIR__.'/auth.php';
