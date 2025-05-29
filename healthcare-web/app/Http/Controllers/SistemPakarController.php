<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Error;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\History;

class SistemPakarController extends Controller
{
    public function predict(Request $request)
    {

        $symptoms = $request->all();
        $symptoms = explode(',', $symptoms['gejala']);
        session(['diagnosis.gejala' => $symptoms]);
        $symptoms = array_map(function ($symptom) {
            return $this->getEngName($symptom);
        }, $symptoms);

        // Remove null values from the array
        $symptoms = array_filter($symptoms, function ($value) {
            return !is_null($value);
        });


        // Make all the array have value true
        $symptomsObj = [];
        foreach ($symptoms as $symptom) {
            $symptomsObj[$symptom] = 1;
        }

        // Send request to the Python Flask API
        $client = new Client();
        $response = $client->post('http://127.0.0.1:5050/predict', [
            'json' => $symptomsObj
        ]);
        // Ambil response JSON
        $result = json_decode($response->getBody()->getContents(), true);
        // dd($result);
        // Bersihkan precaution yang null atau NaN
        foreach ($result as $disease) {
            if (isset($disease['precautions']) && is_array($disease['precautions'])) {
                $disease['precautions'] = array_filter($disease['precautions'], function ($item) {
                    return !is_null($item) && strtolower($item) !== 'nan';
                });
            }
        }

        // Convert ke object (biar bisa pake -> di Blade, opsional sih)
        $resultObject = json_decode(json_encode($result));
        // foreach ($resultObject as $key => $result) {

        //     dd($key);
        //     if (isset($result->probability) && $result->probability <= 0) {
        //         unset($resultObject[$key]);
        //     }
        // }

        // Kirim ke view
        session(['diagnosis.result' => $resultObject]);
        return view('sistem-pakar.process', [
            'step' => 3,
            'result' => $resultObject,
        ]);

    }

    private function getEngName($indName)
    {
        $engName = self::getAllSymptoms()->where('nama_gejala_ind', $indName)->first();

        if ($engName) {
            return $engName->nama_inggris;
        } else {
            return null;
        }
    }

    private function getAllSymptoms()
    {
        $allSymptoms = Gejala::all();

        return $allSymptoms;
    }
    public function index()
    {
        $user = auth()->user();
        if ($user !== null) {
            $history = History::find($user->id);
            return view('sistem-pakar.index', compact('history'));
        } else {
            return view('sistem-pakar.index');
        }
    }

    public function start()
    {
        $user = auth()->user();
        $history = History::where('user_id', $user->id)->get();

        return view('sistem-pakar.index', compact('history'));
    }

    public function history()
    {
        $user = auth()->user();
        $history = History::find($user->id);
        return view('sistem-pakar.history', compact('history'));
    }

    public function submitStep(Request $request)
    {
        $step = (int) $request->query('step', 1);
        $previousSymptoms = session('diagnosis.gejala', []);

        // Simpan data ke session
        if ($request->has('umur')) {
            session(['diagnosis.umur' => $request->input('umur')]);
        }
        if ($request->has('gender')) {
            session(['diagnosis.gender' => $request->input('gender')]);
        }

        return view('sistem-pakar.process', [
            'step' => $step,
            'allSymptoms' => $this->getAllSymptoms(),
            'previousSymptoms' => $previousSymptoms
        ]);
    }

    public function finishDiagnosis(Request $request)
    {
        $result = session('diagnosis');

        // Tambahkan tanggal dan waktu saat fungsi dipanggil
        $calledAt = now(); // Carbon instance, default timezone sesuai config/app.php
        $dateTime = explode(' ', $calledAt->toDateTimeString());
        $date = $dateTime[0];
        $time = $dateTime[1];

        // dd($date, $time);

        // hapus session gejala biar gak numpuk
        session()->forget(['diagnosis.gejala', 'diagnosis.umur', 'diagnosis.gejala', 'diagnosis.gender', 'diagnosis.result']);

        return redirect()->route('sistem-pakar.index');
    }

}
