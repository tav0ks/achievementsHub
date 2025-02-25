<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Serviço para interagir com a API do RetroAchievements.
 */
class RetroAchievementsService
{
    private Client $client;
    private string $baseApiUrl;
    private string $username;
    private string $apiKey;

    /**
     * Construtor do RetroAchievementsService.
     * Inicializa o cliente HTTP e as credenciais da API.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->baseApiUrl = 'https://retroachievements.org/API/';
        $this->username = env('RA_USERNAME');
        $this->apiKey = env('RA_API_KEY');
    }

    /**
     * Faz uma requisição à API do RetroAchievements.
     *
     * @param string $endpoint Endpoint da API
     * @param array $queryParams Parâmetros de consulta
     * @return array|null Dados da resposta
     */
    private function makeRequest(string $endpoint, array $queryParams = []): ?array
    {
        $queryParams['z'] = $this->username;
        $queryParams['y'] = $this->apiKey;

        $url = $this->baseApiUrl . $endpoint . '?' . http_build_query($queryParams);

        try {
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Falha na requisição à API do RetroAchievements: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Recupera o resumo de um jogo específico.
     *
     * @param int $gameId ID do jogo
     * @return array|null Dados do jogo
     */
    public function getGameSummary(int $gameId): ?array
    {
        return $this->makeRequest('API_GetGame.php', [
            'i' => $gameId
        ]);
    }

    /**
     * Recupera as conquistas de um usuário para um jogo específico.
     *
     * @param string $username Nome de usuário do RetroAchievements
     * @param int $gameId ID do jogo
     * @return array|null Dados das conquistas
     */
    public function getUserAchievements(string $username, int $gameId): ?array
    {
        return $this->makeRequest('API_GetUserAchievements.php', [
            'u' => $username,
            'g' => $gameId
        ]);
    }

    /**
     * Recupera a lista de jogos recentemente jogados por um usuário.
     *
     * @param string $username Nome de usuário do RetroAchievements
     * @return array|null Dados dos jogos recentemente jogados
     */
    public function getRecentlyPlayedGames(string $username): ?array
    {
        return $this->makeRequest('API_GetUserRecentlyPlayedGames.php', [
            'u' => $username
        ]);
    }

    /**
     * Recupera a lista dos dez principais usuários.
     *
     * @return array|null Dados dos principais usuários
     */
    public function getTopTenUsers(): ?array
    {
        return $this->makeRequest('API_GetTopTenUsers.php');
    }

    /**
     * Recupera informações detalhadas do jogo e progresso do usuário
     * 
     * @param string $username Nome de usuário do RetroAchievements
     * @param int $gameId ID do jogo
     * @param bool $includeAwards Incluir metadados de conquistas do usuário
     * @return array|null
     */
    public function getGameInfoAndUserProgress(string $username, int $gameId, bool $includeAwards = false): ?array
    {
        return $this->makeRequest('API_GetGameInfoAndUserProgress.php', [
            'u' => $username,
            'g' => $gameId,
            'a' => $includeAwards ? 1 : 0
        ]);
    }

    public function getUserProfile(string $username): ?array
    {
        return $this->makeRequest('API_GetUserProfile.php', [
            'u' => $username
        ]);
    }
}
