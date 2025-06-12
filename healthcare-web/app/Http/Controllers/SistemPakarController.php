<?php

namespace App\Http\Controllers;

use App\Models\Gejala;
use Error;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use \App\Models\DiagnosisSession;
use Carbon\Carbon;
use \App\Models\DiagnosisResult;

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
            $sessions = DiagnosisSession::where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->get();
            return view('sistem-pakar.index', compact('sessions'));
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
        $umur = $session->umur ?? null;
        $gender = $session->gender ?? null;

        return view('sistem-pakar.history', compact('gejala', 'results', 'tanggal', 'waktu', 'id_session', 'umur', 'gender'));
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

        if ($step === 2 && session('diagnosis.umur') == null) {
            abort(404, 'Data tidak ditemukan');
        }
        if (($step === 3 || $step === 4 || $step === 5) && session('diagnosis.result') == null) {
            abort(404, 'Data tidak ditemukan');
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

        // Simpan session diagnosis
        if ($diagnosis['session'] !== null) {
            $session = DiagnosisSession::where('id_session', $diagnosis['session'])
                ->with(['gejalas', 'results'])
                ->firstOrFail();

            // Update data umur dan gender
            $session->umur = $diagnosis['umur'];
            $session->gender = $diagnosis['gender'];
            $session->created_at = now();
            $session->save();

            // Hapus data gejala & hasil lama
            $session->gejalas()->detach();
            DiagnosisResult::where('id_session', $session->id_session)->delete();
        } else {
            $session = DiagnosisSession::create([
                'user_id' => $user->id,
                'created_at' => now(),
                'umur' => $diagnosis['umur'],
                'gender' => $diagnosis['gender']
            ]);
        }

        // Simpan gejala ke tabel pivot session_gejala
        if (!empty($diagnosis['gejala'])) {
            foreach ($diagnosis['gejala'] as $gejalaInd) {
                $gejala = Gejala::where('nama_gejala_ind', $gejalaInd)->first();
                if ($gejala) {
                    $session->gejalas()->attach($gejala->id_gejala);
                }
            }
        }

        // Simpan hasil diagnosis ke diagnosis_result
        if (!empty($diagnosis['result'])) {
            foreach ($diagnosis['result'] as $result) {
                DiagnosisResult::create([
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

    public function destroyHistory($id)
    {
        $session = DiagnosisSession::where('id_session', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Delete related records first
        $session->gejalas()->detach();
        $session->results()->delete();

        // Delete the session
        $session->delete();

        return redirect()
            ->route('sistem-pakar.index')
            ->with('success', 'Riwayat berhasil dihapus');
    }

    public function retake($id)
    {
        $session = DiagnosisSession::where('id_session', $id)
            ->with(['gejalas', 'results'])
            ->firstOrFail();

        // Store the symptoms in session for reuse
        session()->put('diagnosis.umur', $session->umur);
        session()->put('diagnosis.gender', $session->gender);
        session()->put('diagnosis.gejala', $session->gejalas->pluck('nama_gejala_ind')->toArray());

        // Store the results as an array of objects
        $results = $session->results->map(function ($result) {
            return (object) [
                'disease' => $result->nama_penyakit,
                'probability' => $result->probabilitas,
                'description' => $result->deskripsi,
                'precautions' => json_decode($result->precautions)
            ];
        })->toArray();

        session()->put('diagnosis.result', $results);
        session()->put('diagnosis.session', $id);

        return redirect()->route('sistem-pakar.process', ['step' => 1]);
    }
}
