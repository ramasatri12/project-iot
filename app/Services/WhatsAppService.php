<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $apiUrl = 'https://api.callmebot.com/whatsapp.php';

    public function sendMessage($phone, $message)
    {
        $apiKey = env('CALLMEBOT_API_KEY'); // Simpan API key di .env

        $response = Http::get($this->apiUrl, [
            'phone' => $phone,
            'text'  => $message,
            'apikey'=> $apiKey
        ]);

        return $response->successful();
    }
}
