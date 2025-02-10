<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RetroAchievementsService;

class RetroAchievementsController extends Controller
{
    private RetroAchievementsService $retroAchievementsService;

    /**
     * RetroAchievementsController constructor.
     *
     * @param RetroAchievementsService $retroAchievementsService
     */
    public function __construct(RetroAchievementsService $retroAchievementsService)
    {
        $this->retroAchievementsService = $retroAchievementsService;
    }

    /**
     * Exibe o resumo de um jogo específico.
     *
     * @param int $gameId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGameSummary(int $gameId)
    {
        $gameSummary = $this->retroAchievementsService->getGameSummary($gameId);

        if ($gameSummary) {
            return response()->json($gameSummary);
        } else {
            return response()->json(['error' => 'Jogo não encontrado.'], 404);
        }
    }

    /**
     * Exibe as conquistas de um usuário para um jogo específico.
     *
     * @param string $username
     * @param int $gameId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserAchievements(string $username, int $gameId)
    {
        $achievements = $this->retroAchievementsService->getUserAchievements($username, $gameId);

        if ($achievements) {
            return response()->json($achievements);
        } else {
            return response()->json(['error' => 'Conquistas não encontradas.'], 404);
        }
    }

    /**
     * Exibe a lista de jogos recentemente jogados por um usuário.
     *
     * @param string $username
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRecentlyPlayedGames(string $username)
    {
        $recentGames = $this->retroAchievementsService->getRecentlyPlayedGames($username);

        if ($recentGames) {
            return response()->json($recentGames);
        } else {
            return response()->json(['error' => 'Jogos recentemente jogados não encontrados.'], 404);
        }
    }

    /**
     * Exibe a lista dos dez principais usuários.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getTopTenUsers()
    {
        $topUsers = $this->retroAchievementsService->getTopTenUsers();

        if ($topUsers) {
            return response()->json($topUsers);
        } else {
            return response()->json(['error' => 'Não foi possível recuperar a lista dos principais usuários.'], 500);
        }
    }
}
