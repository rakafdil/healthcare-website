<?php

namespace App\Http\Controllers;

use App\Services\AgentService;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    protected $geminiService;

    public function __construct(AgentService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function validateData(Request $request)
    {
        $messages = $request->input('messages', [
            [
                'role' => 'user',
                'content' => '
                {"user_question":"aku keringetan, demam, dan pusing. Pusingnya itu di bagian belakang. Demamku tinggi banget"}

                You are a diagnoses validator and specifier. Your only tasks are:
1. Validate if the user is providing their symptoms/diagnosis.
2. If valid, respond by politely asking *only* about the symptoms they have already mentioned — no new symptoms should be introduced.
3. Always use formal, easy-to-understand language in the `response_for_user`.
4. Always respond strictly in JSON format as follows:
{
    "response_for_user": "string",
    "symptoms": ["string", "string", "..."],
    "symptoms_related": true | false
}

Rules:
- `response_for_user` should be a single sentence or paragraph asking the user follow-up questions about the symptoms they mentioned.
- `symptoms` must be an array containing only the symptoms explicitly mentioned by the user in this turn.
- Do not infer or add unrelated symptoms.
- Always produce valid JSON with no extra text outside the JSON.'
            ]
        ]);

        $response = $this->geminiService->chat($messages);

        return response()->json($response);
    }

    public function predictDisease(Request $request)
    {
        $messages = $request->input('messages', [
            [
                'role' => 'user',
                'content' => '
                {"user_symptoms": ["Keringetan","Demam tinggi","Pusing di bagian belakang"]}
                You are a medical disease prediction assistant.
Your tasks:
1. Predict as accurately as possible what diseases the user might have based on the symptoms they provide.
2. If additional medical knowledge is required, search the web for the most reliable and up-to-date information.
3. Always respond in formal, easy-to-understand Indonesian.
4. You are a strict JSON generator. Respond ONLY with valid JSON in the following format:

{
    "result": [
        {
            "disease": "string",        // the name of predicted disease
            "probability": float,       // disease\'s probabilty from the symptoms
            "description": "string",    // brief descriptions of the disease
            "precautions": [            // list of precaution that user can do
                "string",
                "string"
            ]
        }
    ]
}

Rules:
- Probability must be a decimal number between 0 and 1 (e.g., 0.85 for 85%).
- The "result" array may contain more than one predicted disease.
- All predictions must be relevant to the symptoms provided by the user.
- Do not add unrelated diseases or information.
- Do not output anything outside of the JSON.'
            ]
        ]);
        $response = $this->geminiService->chat($messages);

        $content = response()->json($response);
        $content = $response['content'] ?? '';

        // Hapus triple backticks dan tag json
        $cleanJson = preg_replace('/```(json)?\s*/i', '', $content);
        $cleanJson = preg_replace('/```$/m', '', $cleanJson);
        $cleanJson = trim($cleanJson);

        // Decode ke array PHP
        $data = json_decode($cleanJson, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('Gagal decode JSON: ' . json_last_error_msg());
        }

        return $cleanJson;

    }
}
