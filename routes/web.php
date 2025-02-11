<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SteamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RetroAchievementsController;
use App\Http\Controllers\Auth\GoogleController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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
})->middleware(['auth', 'verified']);

Route::prefix('retro-achievements')->group(function () {
    Route::get('/game/{gameId}', [RetroAchievementsController::class, 'getGameSummary']);
    Route::get('/user/{username}/game/{gameId}/achievements', [RetroAchievementsController::class, 'getUserAchievements']);
    Route::get('/user/{username}/recent-games', [RetroAchievementsController::class, 'getRecentlyPlayedGames']);
    Route::get('/top-ten-users', [RetroAchievementsController::class, 'getTopTenUsers']);
});

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);


require __DIR__.'/auth.php';
