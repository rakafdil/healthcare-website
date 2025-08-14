<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AgentService
{
    protected string $apiUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('OPENROUTER_API_URL', 'https://openrouter.ai/api/v1/chat/completions');
        $this->apiKey = env('OPENROUTER_API_KEY');
    }

    public function chat(array $messages, string $model = 'openai/gpt-oss-20b:free')
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json'
        ])->post($this->apiUrl, [
                    'model' => $model,
                    'messages' => $messages,
                    'format' => [

                    ]
                ])->json();
        ;

        $raw = $response['choices'][0]['message']['content'] ?? '{}';
        return json_decode($raw, true);
    }
}
