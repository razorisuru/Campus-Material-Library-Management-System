<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiAPI
{
    public static function callAPI($prompt)
    {
        $apiKey = env('GEMINI_API_KEY');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" . $apiKey;
        // $systemPrompt = "You are a helpful assistant for the website sibalms.com. sibalms.com offers services like web development, mobile app development, and SEO optimization. If a user asks about services, explain that they can find them on the 'Services' page at https://sibalms.com/services. Always answer questions based on this website information.";
        $systemPrompt = "You are a helpful assistant for the website sibalms.com. ";
        // Send the content to the OpenAI API
        // put the api key to env
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->timeout(300) // Increase timeout to 300 seconds
            ->post($url, [
                'contents' => [
                    [
                        'role' => 'user',
                        'parts' => [
                            [
                                'text' => $systemPrompt,
                            ],
                        ],
                    ],
                    [
                        'role' => 'user',
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
