<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LostFoundController;
use App\Http\Controllers\InteractionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Buy & Sell
    Route::get('/buy-sell', [ProductController::class, 'index'])
        ->name('products.index');

    Route::get('/buy-sell/create', [ProductController::class, 'create'])
        ->name('products.create');

    Route::post('/buy-sell', [ProductController::class, 'store'])
        ->name('products.store');

    Route::get('/buy-sell/{product}/edit', [ProductController::class, 'edit'])
        ->name('products.edit');

    Route::put('/buy-sell/{product}', [ProductController::class, 'update'])
        ->name('products.update');

    Route::patch('/buy-sell/{product}/sold', [ProductController::class, 'markAsSold'])
        ->name('products.sold');

    Route::delete('/buy-sell/{product}', [ProductController::class, 'destroy'])
        ->name('products.destroy');

    Route::get('/buy-sell/{product}', [ProductController::class, 'show'])
        ->name('products.show');

    // Lost & Found
    Route::get('/lost-found', [LostFoundController::class, 'index'])
        ->name('lost-found.index');

    Route::get('/lost-found/create', [LostFoundController::class, 'create'])
        ->name('lost-found.create');

    Route::post('/lost-found', [LostFoundController::class, 'store'])
        ->name('lost-found.store');

    Route::get('/lost-found/{lostFoundPost}/edit', [LostFoundController::class, 'edit'])
        ->name('lost-found.edit');

    Route::put('/lost-found/{lostFoundPost}', [LostFoundController::class, 'update'])
        ->name('lost-found.update');

    Route::patch('/lost-found/{lostFoundPost}/resolve', [LostFoundController::class, 'resolve'])
        ->name('lost-found.resolve');

    Route::delete('/lost-found/{lostFoundPost}', [LostFoundController::class, 'destroy'])
        ->name('lost-found.destroy');

    Route::get('/lost-found/{lostFoundPost}', [LostFoundController::class, 'show'])
        ->name('lost-found.show');

    // Comments and private messages
    Route::post('/interactions/{type}/{id}/comments', [InteractionController::class, 'comment'])
        ->whereIn('type', ['product', 'lost-found'])
        ->name('interactions.comments.store');

    Route::post('/interactions/{type}/{id}/messages', [InteractionController::class, 'message'])
        ->whereIn('type', ['product', 'lost-found'])
        ->name('interactions.messages.store');

    Route::get('/messages', [InteractionController::class, 'inbox'])
        ->name('messages.index');

    Route::post('/messages/{privateMessage}/reply', [InteractionController::class, 'replyToMessage'])
        ->name('messages.reply');

    Route::delete('/interactions/comments/{postComment}', [InteractionController::class, 'destroyComment'])
        ->name('interactions.comments.destroy');

    Route::delete('/messages/{privateMessage}', [InteractionController::class, 'destroyMessage'])
        ->name('messages.destroy');
});

require __DIR__.'/auth.php';