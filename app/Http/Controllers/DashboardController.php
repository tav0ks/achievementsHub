<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SteamService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Services\RetroAchievementsService;

class DashboardController extends Controller
{
    private SteamService $steamService;
    private RetroAchievementsService $retroAchievementsService;

    /**
     * Dashboard constructor.
     * @param SteamService $steamService
     * @param RetroAchievementsService $retroAchievementsService
     */
    public function __construct(SteamService $steamService, RetroAchievementsService $retroAchievementsService)
    {
        $this->steamService = $steamService;
        $this->retroAchievementsService = $retroAchievementsService;
    }

    /**
     * Show the dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $steamData = [];
        $retroData = [];

        // Cache duration (em minutos)
        $cacheDuration = 60; // 1 hora

        // Dados da Steam
        if ($user->steam_id) {
            $steamCacheKey = "user_{$user->id}_steam_data";

            // Verifica se os dados estão em cache
            $steamData = Cache::remember($steamCacheKey, $cacheDuration, function () use ($user) {
                $data = [];

                // Player Summary
                $summaryResponse = $this->steamService->getPlayerSummaries([$user->steam_id]);
                $data['playerSummary'] = $summaryResponse['response']['players'][0] ?? null;

                // Recently Played Games
                $recentlyPlayedResponse = $this->steamService->getRecentlyPlayedGames($user->steam_id);
                $recentlyPlayedGames = $recentlyPlayedResponse['response']['games'] ?? [];
                foreach ($recentlyPlayedGames as &$game) {
                    $game['header'] = "https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/{$game['appid']}/header.jpg";
                    $game['icon'] = $this->steamService->buildImageUrl($game['appid'], $game['img_icon_url'] ?? null);
                }
                $data['recentlyPlayed'] = $recentlyPlayedGames;

                // Owned Games
                $ownedGames = $this->steamService->getOwnedGames($user->steam_id);
                $data['ownedGamesCount'] = count($ownedGames ?? []);
                $data['topGames'] = array_map(function ($game) {
                    $game['header'] = "https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/{$game['appid']}/header.jpg";
                    return $game;
                }, array_slice($ownedGames ?? [], 0, 5));

                // Friends List
                $friendsListResponse = $this->steamService->getFriendList($user->steam_id);
                $friendIds = [];

                if ($friendsListResponse) {
                    $friendIds = array_column($friendsListResponse['friendslist']['friends'], 'steamid');
                }

                if (!empty($friendIds)) {
                    $friendsSummary = $this->steamService->getPlayerSummaries($friendIds);
                    $data['friends'] = $friendsSummary['response']['players'] ?? [];
                } else {
                    $data['friends'] = [];
                }

                return $data;
            });
        }

        // Dados do RetroAchievements
        if ($user->retroachievements_username) {
            $retroCacheKey = "user_{$user->id}_retro_data";

            // Verifica se os dados estão em cache
            $retroData = Cache::remember($retroCacheKey, $cacheDuration, function () use ($user) {
                $data = [];

                $retroProfile = $this->retroAchievementsService->getUserProfile($user->retroachievements_username);

                if ($retroProfile) {
                    $data = [
                        'profile' => [
                            'username' => $retroProfile['User'],
                            'avatar' => 'https://media.retroachievements.org' . $retroProfile['UserPic'],
                            'memberSince' => $retroProfile['MemberSince'],
                            'totalPoints' => $retroProfile['TotalPoints'],
                            'totalTruePoints' => $retroProfile['TotalTruePoints'],
                            'lastGame' => $this->retroAchievementsService->getGameSummary($retroProfile['LastGameID']),
                            'richPresence' => $retroProfile['RichPresenceMsg'],
                            'motto' => $retroProfile['Motto']
                        ],
                        'recentGames' => $this->retroAchievementsService->getRecentlyPlayedGames($user->retroachievements_username)
                    ];
                }

                return $data;
            });
        }

        return view('dashboard', array_merge([
            'user' => $user,
            'steamData' => $steamData,
            'retroData' => $retroData
        ]));
    }
}