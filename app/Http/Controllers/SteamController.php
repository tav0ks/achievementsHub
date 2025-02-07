<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SteamService;

class SteamController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new SteamService();
    }

    public function getOwnedGames($steam_id)
    {
        $data = $this->service->GetOwnedGames($steam_id);

        dd($data);
    }
}
