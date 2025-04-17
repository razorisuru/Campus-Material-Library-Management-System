<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiAPI
{
    public static function calAPI($prompt)
    {
        $apiKey = env('GEMINI_API_KEY');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;
        // Send the content to the OpenAI API
        // put the api key to env
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(300) // Increase timeout to 300 seconds
            ->post($url, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt,
                            ],
                        ],
                    ],
                ],
            ]);

        if ($response->failed()) {
            // Handle the error
            return $response;
        }
        return $response->json();

    }
}
