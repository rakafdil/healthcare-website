<?php

namespace App\Http\Controllers;

use App\Services\AgentService;
use Illuminate\Http\Request;

class AgentController extends Controller
{
    protected $openRouterService;

    public function __construct(AgentService $openRouterService)
    {
        $this->openRouterService = $openRouterService;
    }

    public function validateData(Request $request)
    {
        $messages = $request->input('messages', [
            [
                'role' => 'system',
                'content' => 'You are here to validate is the user inputting their diagnoses. If they are correct, identify and ask them further for the details. Reply the user with their formal language. And also You are a strict JSON generator. Respond ONLY with valid JSON in the following format:
        {
            "response_for_user": "string",
            "symptoms": ["string", "string", "..."],
            "symptoms_related": true
        }'
            ],
            ['role' => 'user', 'content' => 'aku keringetan, demam, dan pusing. Pusingnya itu di bagian belakang. Demamku tinggi banget']
        ]);

        $model = $request->input('model', 'openai/gpt-oss-20b:free');

        $response = $this->openRouterService->chat($messages, $model);

        return response()->json($response);
    }

    public function predictDisease(Request $request)
    {
        $messages = $request->input('messages', [
            [
                'role' => 'system',
                'content' => 'You are here to predict what diseases that may the user have. Reply the user with their formal language. And also You are a strict JSON generator. Respond ONLY with valid JSON in the following format:
        {
            "response_for_user": "string",
            "result": [
                {
            "nama_penyakit": "string",
            "probabilitas": "float",
            "deskripsi": "string",
            "precautions": "string",
                }
            ]
        }'
            ],
            [
                'role' => 'user',
                'content' => '
            "symptoms":["Keringetan","Demam tinggi","Pusing di bagian belakang"]
            '
            ]
        ]);

        $model = $request->input('model', 'openai/gpt-oss-20b:free');

        $response = $this->openRouterService->chat($messages, $model);

        return response()->json($response);
    }
}
