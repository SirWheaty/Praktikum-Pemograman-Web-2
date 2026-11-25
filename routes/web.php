<?php

use App\Http\Controllers\BukuController;
use App\Http\Controllers\ContactAdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

Route::get('/contact', [ContactController::class, 'create'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:contact')
    ->name('contact.store');

Route::get('/post', [PostController::class, 'index'])->name('post.index');
Route::middleware('auth')->group(function () {
    Route::get('/post/profile-saya', [PostController::class, 'profileSaya'])->name('post.profile-saya');
    Route::get('/post/create', [PostController::class, 'create'])->middleware('admin')->name('post.create');
    Route::post('/post', [PostController::class, 'store'])->middleware('admin')->name('post.store');
});

Route::middleware(['auth', 'verified'])->prefix('post')->name('post.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/contacts', [ContactAdminController::class, 'index'])
        ->middleware('admin')
        ->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactAdminController::class, 'show'])
        ->middleware('admin')
        ->name('contacts.show');
});

Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('post.show');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store');
    Route::get('/gallery/{gallery}/edit', [GalleryController::class, 'edit'])->name('gallery.edit');
    Route::put('/gallery/{gallery}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/gallery/{gallery}', [GalleryController::class, 'destroy'])->name('gallery.destroy');
});
Route::get('/projects/create', [ProjectController::class, 'create'])
    ->middleware('auth')
    ->name('projects.create');
Route::post('/projects', [ProjectController::class, 'store'])
    ->middleware('auth')
    ->name('projects.store');
Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])
    ->middleware('auth')
    ->name('projects.edit');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::put('/projects/{project}', [ProjectController::class, 'update'])
    ->middleware('auth')
    ->name('projects.update');
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])
    ->middleware('auth')
    ->name('projects.destroy');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/contacts', [ContactAdminController::class, 'index'])
    ->middleware(['auth', 'verified', 'admin'])
    ->name('contacts.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
