<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SteamService;
use Illuminate\Support\Facades\Auth;
use App\Services\RetroAchievementsService;

class DashboardController extends Controller
{
    private SteamService $steamService;
    private RetroAchievementsService $retroAchievementsService;

    /**
     * Dashboard constructor.
     * @param SteamService $steamService
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

        if ($user->steam_id) {
            // Player Summary
            $summaryResponse = $this->steamService->getPlayerSummaries([$user->steam_id]);
            $steamData['playerSummary'] = $summaryResponse['response']['players'][0] ?? null;

            // Recently Played Games
            $recentlyPlayedResponse = $this->steamService->getRecentlyPlayedGames($user->steam_id);
            $recentlyPlayedGames = $recentlyPlayedResponse['response']['games'] ?? [];
            foreach ($recentlyPlayedGames as &$game) {
                $game['header'] = "https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/{$game['appid']}/header.jpg";
                $game['icon'] = $this->steamService->buildImageUrl($game['appid'], $game['img_icon_url'] ?? null);
            }
            $steamData['recentlyPlayed'] = $recentlyPlayedGames;

            // Owned Games com headers
            $ownedGames = $this->steamService->getOwnedGames($user->steam_id);
            $steamData['ownedGamesCount'] = count($ownedGames ?? []);
            $steamData['topGames'] = array_map(function ($game) {
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
                $steamData['friends'] = $friendsSummary['response']['players'] ?? [];
            } else {
                $steamData['friends'] = [];
            }
        }

        if ($user->retroachievements_username) {
            $retroProfile = $this->retroAchievementsService->getUserProfile($user->retroachievements_username);

            if ($retroProfile) {
                $retroData = [
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
        }

        // dd($retroData);

        return view('dashboard', array_merge([
            'user' => $user,
            'steamData' => $steamData,
            'retroData' => $retroData
        ]));
    }
}
