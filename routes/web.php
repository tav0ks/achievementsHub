<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SteamController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('steam')->group(function () {
    Route::get('owned-games/{steamId}', [SteamController::class, 'getOwnedGames']);
    Route::get('news/{appId}', [SteamController::class, 'getNewsForApp']);
    Route::get('achievements/{appId}', [SteamController::class, 'getGlobalAchievementPercentagesForApp']);
    Route::get('player-summaries', [SteamController::class, 'getPlayerSummaries']);
    Route::get('friends/{steamId}', [SteamController::class, 'getFriendList']);
    Route::get('player-achievements/{steamId}/{appId}', [SteamController::class, 'getPlayerAchievements']);
    Route::get('user-stats/{steamId}/{appId}', [SteamController::class, 'getUserStatsForGame']);
    Route::get('recently-played/{steamId}', [SteamController::class, 'getRecentlyPlayedGames']);
});

require __DIR__.'/auth.php';
