<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Error;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\History;
use \App\Models\DiagnosisSession;
use Carbon\Carbon;

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
        // dd($symptoms);
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
            return $engName->nama_gejala_eng;
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
        $sessions = [];
        if ($user !== null) {
            $history = History::find($user->id);
            $sessions = DiagnosisSession::where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->get();
            return view('sistem-pakar.index', compact('history', 'sessions'));
        } else {
            return view('sistem-pakar.index', compact('sessions'));
        }
    }

    // public function start()
    // {
    //     $user = auth()->user();
    //     $history = History::where('user_id', $user->id)->get();

    //     return view('sistem-pakar.index', compact('history'));
    // }

    public function history(Request $request)
    {
        $user = auth()->user();
        $id_session = $request->input('history_id');

        // Ambil satu session diagnosis beserta relasinya
        $session = DiagnosisSession::where('id_session', $id_session)
            ->with(['gejalas', 'results'])
            ->first();

        if (!$session) {
            abort(404, 'Data tidak ditemukan');
        }

        $gejala = $session->gejalas;
        $results = $session->results;

        $date_time = Carbon::parse($session->created_at);
        $tanggal = $date_time->format('d-m-Y');
        $waktu = $date_time->format('H:i:s');

        return view('sistem-pakar.history', compact('gejala', 'results', 'tanggal', 'waktu', 'id_session'));
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
        $user = auth()->user();
        $diagnosis = session('diagnosis');
        if (!$user || !$diagnosis) {
            return redirect()->route('sistem-pakar.index')->with('error', 'Session tidak valid.');
        }

        // 1. Simpan session diagnosis
        $session = DiagnosisSession::create([
            'user_id' => $user->id,
            'created_at' => now(),
        ]);

        // 2. Simpan gejala ke tabel pivot session_gejala
        if (!empty($diagnosis['gejala'])) {
            foreach ($diagnosis['gejala'] as $gejalaInd) {
                $gejala = Gejala::where('nama_gejala_ind', $gejalaInd)->first();
                if ($gejala) {
                    $session->gejalas()->attach($gejala->id_gejala);
                }
            }
        }

        // 3. Simpan hasil diagnosis ke diagnosis_result
        if (!empty($diagnosis['result'])) {
            foreach ($diagnosis['result'] as $result) {
                \App\Models\DiagnosisResult::create([
                    'id_session' => $session->id_session,
                    'nama_penyakit' => $result->disease ?? '',
                    'probabilitas' => $result->probability ?? 0,
                    'deskripsi' => $result->description ?? '',
                    'precautions' => isset($result->precautions) ? json_encode($result->precautions) : null,
                ]);
            }
        }

        // Hapus session diagnosis
        session()->forget(['diagnosis.gejala', 'diagnosis.umur', 'diagnosis.gender', 'diagnosis.result']);

        return redirect()->route('sistem-pakar.index')->with('success', 'Hasil diagnosis berhasil disimpan.');
    }

}
