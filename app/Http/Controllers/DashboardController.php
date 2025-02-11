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
        
        $steamId = $user->steam_id;

        $ownedGames = $this->steamService->getOwnedGames($steamId);

        $recentlyPlayedGames = $this->steamService->getRecentlyPlayedGames($steamId);

        $playerSummaries = $this->steamService->getPlayerSummaries([$steamId]);

        return view('dashboard', [
            'ownedGames' => $ownedGames,
            'recentlyPlayedGames' => $recentlyPlayedGames,
            'playerSummaries' => $playerSummaries,
        ]);
    }
}
