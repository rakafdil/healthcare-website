<?php

namespace App\Http\Controllers;

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
        $engName = self::getAllSymptoms()[$indName] ?? null;

        if ($engName) {
            return $engName;
        } else {
            return null;
        }
    }

    private function getAllSymptoms()
    {
        $allSymptoms = [
            'gatal' => 'itching',
            'ruam kulit' => 'skin_rash',
            'erupsi nodul kulit' => 'nodal_skin_eruptions',
            'bersin terus menerus' => 'continuous_sneezing',
            'menggigil' => 'shivering',
            'kedinginan' => 'chills',
            'nyeri sendi' => 'joint_pain',
            'sakit perut' => 'stomach_pain',
            'asam lambung' => 'acidity',
            'luka di lidah' => 'ulcers_on_tongue',
            'penyusutan otot' => 'muscle_wasting',
            'muntah' => 'vomiting',
            'nyeri saat buang air kecil' => 'burning_micturition',
            'bercak saat buang air kecil' => 'spotting_urination',
            'kelelahan' => 'fatigue',
            'penambahan berat badan' => 'weight_gain',
            'kecemasan' => 'anxiety',
            'tangan dan kaki dingin' => 'cold_hands_and_feets',
            'perubahan suasana hati' => 'mood_swings',
            'penurunan berat badan' => 'weight_loss',
            'gelisah' => 'restlessness',
            'lemas' => 'lethargy',
            'bercak di tenggorokan' => 'patches_in_throat',
            'gula darah tidak teratur' => 'irregular_sugar_level',
            'batuk' => 'cough',
            'demam tinggi' => 'high_fever',
            'mata cekung' => 'sunken_eyes',
            'sesak napas' => 'breathlessness',
            'keringat berlebihan' => 'sweating',
            'dehidrasi' => 'dehydration',
            'gangguan pencernaan' => 'indigestion',
            'sakit kepala' => 'headache',
            'kulit menguning' => 'yellowish_skin',
            'urin gelap' => 'dark_urine',
            'mual' => 'nausea',
            'hilang nafsu makan' => 'loss_of_appetite',
            'sakit di belakang mata' => 'pain_behind_the_eyes',
            'sakit punggung' => 'back_pain',
            'sembelit' => 'constipation',
            'sakit perut bagian bawah' => 'abdominal_pain',
            'diare' => 'diarrhoea',
            'demam ringan' => 'mild_fever',
            'urin kuning' => 'yellow_urine',
            'mata menguning' => 'yellowing_of_eyes',
            'gagal hati akut' => 'acute_liver_failure',
            'kelebihan cairan' => 'fluid_overload',
            'perut bengkak' => 'swelling_of_stomach',
            'pembengkakan kelenjar getah bening' => 'swelled_lymph_nodes',
            'malaise' => 'malaise',
            'penglihatan buram dan terdistorsi' => 'blurred_and_distorted_vision',
            'dahak' => 'phlegm',
            'iritasi tenggorokan' => 'throat_irritation',
            'kemerahan pada mata' => 'redness_of_eyes',
            'tekanan sinus' => 'sinus_pressure',
            'hidung meler' => 'runny_nose',
            'hidung tersumbat' => 'congestion',
            'nyeri dada' => 'chest_pain',
            'kelemahan anggota tubuh' => 'weakness_in_limbs',
            'detak jantung cepat' => 'fast_heart_rate',
            'nyeri saat buang air besar' => 'pain_during_bowel_movements',
            'nyeri di daerah anus' => 'pain_in_anal_region',
            'tinja berdarah' => 'bloody_stool',
            'iritasi di anus' => 'irritation_in_anus',
            'sakit leher' => 'neck_pain',
            'pusing' => 'dizziness',
            'kram' => 'cramps',
            'memar' => 'bruising',
            'obesitas' => 'obesity',
            'kaki bengkak' => 'swollen_legs',
            'pembuluh darah bengkak' => 'swollen_blood_vessels',
            'wajah dan mata bengkak' => 'puffy_face_and_eyes',
            'pembesaran tiroid' => 'enlarged_thyroid',
            'kuku rapuh' => 'brittle_nails',
            'ekstremitas bengkak' => 'swollen_extremeties',
            'lapar berlebihan' => 'excessive_hunger',
            'kontak di luar pernikahan' => 'extra_marital_contacts',
            'bibir kering dan kesemutan' => 'drying_and_tingling_lips',
            'bicara pelo' => 'slurred_speech',
            'nyeri lutut' => 'knee_pain',
            'nyeri sendi pinggul' => 'hip_joint_pain',
            'kelemahan otot' => 'muscle_weakness',
            'leher kaku' => 'stiff_neck',
            'sendi bengkak' => 'swelling_joints',
            'kekakuan gerakan' => 'movement_stiffness',
            'gerakan berputar' => 'spinning_movements',
            'kehilangan keseimbangan' => 'loss_of_balance',
            'ketidakstabilan' => 'unsteadiness',
            'kelemahan satu sisi tubuh' => 'weakness_of_one_body_side',
            'kehilangan penciuman' => 'loss_of_smell',
            'ketidaknyamanan kandung kemih' => 'bladder_discomfort',
            'bau urin tidak sedap' => 'foul_smell_ofurine',
            'rasa ingin buang air kecil terus menerus' => 'continuous_feel_of_urine',
            'keluar gas' => 'passage_of_gases',
            'gatal dari dalam' => 'internal_itching',
            'wajah tampak toksik (tifus)' => 'toxic_look_(typhos)',
            'depresi' => 'depression',
            'mudah marah' => 'irritability',
            'nyeri otot' => 'muscle_pain',
            'kesadaran terganggu' => 'altered_sensorium',
            'bintik merah di tubuh' => 'red_spots_over_body',
            'sakit perutt' => 'belly_pain',
            'menstruasi tidak normal' => 'abnormal_menstruation',
            'bercak diskromik' => 'dischromic_patches',
            'mata berair' => 'watering_from_eyes',
            'nafsu makan meningkat' => 'increased_appetite',
            'sering buang air kecil' => 'polyuria',
            'riwayat keluarga' => 'family_history',
            'dahak berlendir' => 'mucoid_sputum',
            'dahak berkarat' => 'rusty_sputum',
            'kurang konsentrasi' => 'lack_of_concentration',
            'gangguan penglihatan' => 'visual_disturbances',
            'menerima transfusi darah' => 'receiving_blood_transfusion',
            'menerima suntikan tidak steril' => 'receiving_unsterile_injections',
            'koma' => 'coma',
            'perdarahan lambung' => 'stomach_bleeding',
            'perut kembung' => 'distention_of_abdomen',
            'riwayat konsumsi alkohol' => 'history_of_alcohol_consumption',
            'darah dalam dahak' => 'blood_in_sputum',
            'pembuluh darah betis menonjol' => 'prominent_veins_on_calf',
            'jantung berdebar' => 'palpitations',
            'nyeri saat berjalan' => 'painful_walking',
            'jerawat bernanah' => 'pus_filled_pimples',
            'komedo' => 'blackheads',
            'kerak kulit' => 'scurring',
            'kulit mengelupas' => 'skin_peeling',
            'seperti debu perak' => 'silver_like_dusting',
            'lekukan kecil di kuku' => 'small_dents_in_nails',
            'kuku meradang' => 'inflammatory_nails',
            'lepuhan' => 'blister',
            'luka merah di sekitar hidung' => 'red_sore_around_nose',
            'kerak kuning yang keluar' => 'yellow_crust_ooze',
        ];

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
