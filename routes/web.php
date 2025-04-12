<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\SetLocale;
use Illuminate\Support\Facades\Route;

Route::post('/admin/tiptap-image-upload', [TiptapImageUploadController::class, 'upload'])
    ->name('admin.tiptap.upload');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/blog', [PostController::class, 'index'])->name('posts.index');

Route::get('/blog/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::post('/comments/{post:id}', [CommentController::class, 'store'])->name('posts.comment');

Route::get('/language/{locale}', function($locale) {
    if(array_key_exists($locale, config('app.supported_locales'))) {
        session()->put('locale', $locale);
    }
    return redirect()->back();
})->name('language.switch');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
   // Route::get('/dashboard', function () {
   //     return view('dashboard');
   // })->name('dashboard');
});
