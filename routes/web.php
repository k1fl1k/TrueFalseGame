<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use k1fl1k\truefalsegame\Http\Controllers\AdminController;
use k1fl1k\truefalsegame\Http\Controllers\CommentController;
use k1fl1k\truefalsegame\Http\Controllers\LikeController;
use k1fl1k\truefalsegame\Http\Controllers\ProfileController;
use k1fl1k\truefalsegame\Http\Controllers\TruthOrLieGameController;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/profile', [ProfileController::class, 'show'])
    ->middleware(['auth'])
    ->name('profile');

Route::view('settings', 'settings')->name('settings.show');

Route::get('/truth-or-lie/create', [TruthOrLieGameController::class, 'create'])->name('truth-or-lie.create');
Route::post('/truth-or-lie', [TruthOrLieGameController::class, 'store'])->name('truth-or-lie.store');
Route::get('/truth-or-lie/{id}', [TruthOrLieGameController::class, 'show'])->name('truth-or-lie.show');
Route::get('truth-or-lie/play/{id}', [TruthOrLieGameController::class, 'play'])->name('truth-or-lie.play');
Route::post('truth-or-lie/{game}/submit-answer', [TruthOrLieGameController::class, 'submitAnswer'])->name('game.submitAnswer');
Route::post('truth-or-lie/{game}/comments', [CommentController::class, 'store'])
    ->name('comments.storeGame')
    ->middleware(['auth']);
Route::post('truth-or-lie/{game}/like', [LikeController::class, 'toggle'])->name('likes.toggle')
    ->middleware(['auth']);
// Видалення коментаря
Route::delete('truth-or-lie/{game}/comments/{comment}', [CommentController::class, 'destroy'])
    ->name('comments.destroyGame')
    ->middleware(['auth']);
Route::patch('/truth-or-lie/{id}/toggle-public', [TruthOrLieGameController::class, 'togglePublic'])
    ->name('truth-or-lie.toggle-public')
    ->middleware('auth');
Route::get('/gamehub', [TruthOrLieGameController::class, 'index'])->name('truth-or-lie.gamehub');

require __DIR__.'/auth.php';
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login'); // або ->to('/')
})->name('logout');
Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Панель адміністратора
    Route::get('/', [AdminController::class, 'index'])->name('admin.panel');

    // Роут для керування користувачами
    Route::get('/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::patch('/admin/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.updateRole');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Роут для керування контентом
    Route::get('/content', [AdminController::class, 'manageContent'])->name('admin.content');
    Route::delete('/admin/games/{id}', [AdminController::class, 'destroyGame'])->name('admin.games.destroy');
});
