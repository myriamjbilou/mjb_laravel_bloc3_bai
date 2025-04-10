<?php

use App\Http\Controllers\CookieConsentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ideacontroller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrivacyCharterController;
use App\Http\Middleware\CheckPrivacyCharterAcceptance;
use App\Http\Controllers\ConsentController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\RedirectController;





Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Routes pour les idées
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('idea', ideacontroller::class);
});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Routes pour les commentaires (en lien avec les idées)
    Route::post('/idea/{idea}/comments', [IdeaController::class, 'storeComment'])->name('comments.store');
    Route::patch('/comments/{comment}', [IdeaController::class, 'updateComment'])->name('comments.update');
    Route::delete('/comments/{comment}', [IdeaController::class, 'destroyComment'])->name('comments.destroy');
});

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

Route::get('/cookie', function () {
    return view('cookie');
});

Route::get('/politique-de-cookie', function () {
    return view('politique-de-cookie');
});

Route::post('/save-consent', [ConsentController::class, 'store'])->name('consent.store');

Route::get('/logs', [LogController::class, 'index'])->name('logs.index');


Route::get('/filter', [ImportController::class, 'filterDump'])->name('import.filter');

Route::get('/redirect', [RedirectController::class, 'redirect'])->name('redirect.test');


require __DIR__ . '/auth.php';

