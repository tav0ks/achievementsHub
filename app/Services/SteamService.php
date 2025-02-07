<?php

namespace App\Services;

use DateTime;
use Carbon\Carbon;
use App\Models\User;
use GuzzleHttp\Client;
use App\Models\Contract;
use App\Models\Financial;
use App\Models\Installment;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class SteamService
{
    private $client;
    private $headers;
    private $body;
    private $baseApiUrl;
    private $apiKey;

    public function __construct()
    {
        $this->client = new Client();

        $this->baseApiUrl = 'http://api.steampowered.com/';

        $this->apiKey = env('STEAM_API_KEY');
    }

    public function GetOwnedGames($steam_id)
    {
        $req = new Request('GET', $this->baseApiUrl . 'IPlayerService/GetOwnedGames/v0001/?key=' . $this->apiKey . '&steamid=' . $steam_id . '&format=json');

        $res = $this->client->sendAsync($req)->wait();

        return json_decode($res->getBody()->getContents());
    }
}
