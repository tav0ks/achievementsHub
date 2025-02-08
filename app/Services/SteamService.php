<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

/**
 * Service for interacting with the Steam Web API.
 */
class SteamService
{
    private Client $client;
    private string $baseApiUrl;
    private string $apiKey;

    /**
     * SteamService constructor.
     * Initializes the HTTP client and API key.
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->baseApiUrl = 'http://api.steampowered.com/';
        $this->apiKey = env('STEAM_API_KEY');
    }

    /**
     * Makes a request to the Steam API.
     *
     * @param string $endpoint API endpoint
     * @param array $queryParams Query parameters
     * @return array|null Response data
     */
    private function makeRequest(string $endpoint, array $queryParams = []): ?array
    {
        $queryParams['key'] = $this->apiKey;
        $queryParams['format'] = 'json';

        $url = $this->baseApiUrl . $endpoint . '?' . http_build_query($queryParams);

        try {
            $response = $this->client->request('GET', $url);
            return json_decode($response->getBody()->getContents(), true);
        } catch (GuzzleException $e) {
            Log::error('Steam API request failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Retrieves the list of games owned by a player.
     *
     * @param string $steamId Steam user ID
     * @return array|null Owned games data
     */
    public function getOwnedGames(string $steamId): ?array
    {
        return $this->makeRequest('IPlayerService/GetOwnedGames/v0001', ['steamid' => $steamId]);
    }

    /**
     * Retrieves the latest news for a specific game.
     *
     * @param int $appId Game App ID
     * @param int $count Number of news articles to retrieve
     * @param int $maxLength Maximum length of news entries
     * @return array|null News data
     */
    public function getNewsForApp(int $appId, int $count = 3, int $maxLength = 300): ?array
    {
        return $this->makeRequest('ISteamNews/GetNewsForApp/v0002', [
            'appid' => $appId,
            'count' => $count,
            'maxlength' => $maxLength
        ]);
    }

    /**
     * Retrieves global achievement percentages for a specific game.
     *
     * @param int $appId Game App ID
     * @return array|null Achievement percentage data
     */
    public function getGlobalAchievementPercentagesForApp(int $appId): ?array
    {
        return $this->makeRequest('ISteamUserStats/GetGlobalAchievementPercentagesForApp/v0002', [
            'gameid' => $appId
        ]);
    }

    /**
     * Retrieves player summaries for a list of Steam IDs.
     *
     * @param array $steamIds Array of Steam user IDs
     * @return array|null Player summaries data
     */
    public function getPlayerSummaries(array $steamIds): ?array
    {
        return $this->makeRequest('ISteamUser/GetPlayerSummaries/v0002', [
            'steamids' => implode(',', $steamIds)
        ]);
    }

    /**
     * Retrieves the friend list of a Steam user.
     *
     * @param string $steamId Steam user ID
     * @param string $relationship Relationship filter (default: 'friend')
     * @return array|null Friend list data
     */
    public function getFriendList(string $steamId, string $relationship = 'friend'): ?array
    {
        return $this->makeRequest('ISteamUser/GetFriendList/v0001', [
            'steamid' => $steamId,
            'relationship' => $relationship
        ]);
    }

    /**
     * Retrieves a player's achievements for a specific game.
     *
     * @param string $steamId Steam user ID
     * @param int $appId Game App ID
     * @param string $language Language for achievement names and descriptions
     * @return array|null Achievement data
     */
    public function getPlayerAchievements(string $steamId, int $appId, string $language = 'en'): ?array
    {
        return $this->makeRequest('ISteamUserStats/GetPlayerAchievements/v0001', [
            'steamid' => $steamId,
            'appid' => $appId,
            'l' => $language
        ]);
    }

    /**
     * Retrieves user statistics for a specific game.
     *
     * @param string $steamId Steam user ID
     * @param int $appId Game App ID
     * @param string $language Language for statistic names
     * @return array|null User statistics data
     */
    public function getUserStatsForGame(string $steamId, int $appId, string $language = 'en'): ?array
    {
        return $this->makeRequest('ISteamUserStats/GetUserStatsForGame/v0002', [
            'steamid' => $steamId,
            'appid' => $appId,
            'l' => $language
        ]);
    }

    /**
     * Retrieves the list of recently played games for a Steam user.
     *
     * @param string $steamId Steam user ID
     * @param int $count Number of recent games to retrieve
     * @return array|null Recently played games data
     */
    public function getRecentlyPlayedGames(string $steamId, int $count = 5): ?array
    {
        return $this->makeRequest('IPlayerService/GetRecentlyPlayedGames/v0001', [
            'steamid' => $steamId,
            'count' => $count
        ]);
    }
}
