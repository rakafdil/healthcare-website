<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AgentService
{
    protected string $apiUrl;
    protected string $apiKey;

    public function __construct()
    {
        $this->apiUrl = env('GEMINI_API_URL', 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent');
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function chat(array $messages)
    {
        $apiKey = env('GEMINI_API_KEY');

        try {
            $contents = [];
            foreach ($messages as $msg) {
                $contents[] = [
                    'role' => $msg['role'],
                    'parts' => [
                        ['text' => $msg['content']]
                    ]
                ];
            }

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])
                ->timeout(60)
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
                    'contents' => $contents
                ]);


            $json = $response->json();

            if (isset($json['error'])) {
                \Log::error("Gemini API gagal: " . json_encode($json['error']));
                return [
                    'model_used' => 'gemini-2.5-flash',
                    'content' => 'Terjadi error saat menghubungi Gemini API.'
                ];
            }

            if (!empty($json['candidates'][0]['content']['parts'][0]['text'])) {
                return [
                    'model_used' => 'gemini-2.5-flash',
                    'content' => $json['candidates'][0]['content']['parts'][0]['text']
                ];
            }

        } catch (\Exception $e) {
            \Log::error("Request ke Gemini API error: " . $e->getMessage());
            return [
                'model_used' => 'gemini-2.5-flash',
                'content' => 'Gagal menghubungi API.'
            ];
        }

        return [
            'model_used' => 'gemini-2.5-flash',
            'content' => 'Tidak ada respons dari API.'
        ];
    }
}
