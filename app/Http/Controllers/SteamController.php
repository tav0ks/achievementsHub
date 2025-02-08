<?php

namespace App\Http\Controllers;

use App\Services\SteamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SteamController extends Controller
{
    private SteamService $steamService;

    /**
     * SteamController constructor.
     * @param SteamService $steamService
     */
    public function __construct(SteamService $steamService)
    {
        $this->steamService = $steamService;
    }

    /**
     * Get owned games of a Steam user.
     */
    public function getOwnedGames(string $steamId): JsonResponse
    {
        return response()->json($this->steamService->getOwnedGames($steamId));
    }

    /**
     * Get news for a specific game.
     */
    public function getNewsForApp(int $appId, Request $request): JsonResponse
    {
        $count = $request->query('count', 3);
        $maxLength = $request->query('maxlength', 300);
        return response()->json($this->steamService->getNewsForApp($appId, $count, $maxLength));
    }

    /**
     * Get global achievement percentages for a game.
     */
    public function getGlobalAchievementPercentagesForApp(int $appId): JsonResponse
    {
        return response()->json($this->steamService->getGlobalAchievementPercentagesForApp($appId));
    }

    /**
     * Get player summaries for a list of Steam IDs.
     */
    public function getPlayerSummaries(Request $request): JsonResponse
    {
        $steamIds = explode(',', $request->query('steamids'));
        return response()->json($this->steamService->getPlayerSummaries($steamIds));
    }

    /**
     * Get the friend list of a Steam user.
     */
    public function getFriendList(string $steamId): JsonResponse
    {
        return response()->json($this->steamService->getFriendList($steamId));
    }

    /**
     * Get a player's achievements for a game.
     */
    public function getPlayerAchievements(string $steamId, int $appId): JsonResponse
    {
        return response()->json($this->steamService->getPlayerAchievements($steamId, $appId));
    }

    /**
     * Get user stats for a game.
     */
    public function getUserStatsForGame(string $steamId, int $appId): JsonResponse
    {
        return response()->json($this->steamService->getUserStatsForGame($steamId, $appId));
    }

    /**
     * Get recently played games of a Steam user.
     */
    public function getRecentlyPlayedGames(string $steamId, Request $request): JsonResponse
    {
        $count = $request->query('count', 5);
        return response()->json($this->steamService->getRecentlyPlayedGames($steamId, $count));
    }
}
