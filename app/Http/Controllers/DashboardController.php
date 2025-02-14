<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SteamService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    private SteamService $steamService;

    /**
     * Dashboard constructor.
     * @param SteamService $steamService
     */
    public function __construct(SteamService $steamService)
    {
        $this->steamService = $steamService;
    }

    /**
     * Show the dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $steamData = [];

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

        return view('dashboard', array_merge(['user' => $user], $steamData));
    }
}
