<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Services\RetroAchievementsService;

class GameProgressController extends Controller
{
    private RetroAchievementsService $retroService;

    public function __construct(RetroAchievementsService $retroService)
    {
        $this->retroService = $retroService;
    }

    /**
     * Mostra o progresso do usuário em um jogo específico
     */
    public function show(string $username, int $gameId)
    {
        try {
            $progressData = $this->retroService->getGameInfoAndUserProgress(
                username: $username,
                gameId: $gameId,
                includeAwards: true
            );

            if (!$progressData) {
                return response()->json(['error' => 'Dados não encontrados'], 404);
            }

            return response()->json($this->formatProgressData($progressData));

        } catch (\Exception $e) {
            Log::error('Erro ao buscar progresso do jogo: ' . $e->getMessage());
            return response()->json(['error' => 'Erro interno do servidor'], 500);
        }
    }

    /**
     * Formata os dados da resposta da API
     */
    private function formatProgressData(array $data): array
    {
        return [
            'game_id' => $data['ID'],
            'title' => $data['Title'],
            'console' => $data['ConsoleName'],
            'achievements' => $this->formatAchievements($data['Achievements'] ?? []),
            'completion' => [
                'normal' => $data['UserCompletion'],
                'hardcore' => $data['UserCompletionHardcore']
            ],
            'last_updated' => $data['HighestAwardDate']
        ];
    }

    /**
     * Formata a lista de conquistas
     */
    private function formatAchievements(array $achievements): array
    {
        return array_map(function ($achievement) {
            return [
                'id' => $achievement['ID'],
                'title' => $achievement['Title'],
                'description' => $achievement['Description'],
                'points' => $achievement['Points'],
                'unlocked_at' => $achievement['DateEarned'] ?? null,
                'unlocked_hardcore' => $achievement['DateEarnedHardcore'] ?? null
            ];
        }, $achievements);
    }
}