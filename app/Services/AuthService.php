<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('AUTH_SERVICE_URL', 'http://localhost:8003');
    }

    public function getUserFromToken($token)
    {
        $response = Http::withToken($token)
            ->get("{$this->baseUrl}/api/user");

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }
}
