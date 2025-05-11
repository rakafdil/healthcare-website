<?php

namespace App\Http\Controllers;

use Error;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MLController extends Controller
{
    public function predict(Request $request)
    {

        $symptoms = $request->all();
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
            $symptomsObj[$symptom] = true;
        }

        // Convert the array to a JSON string
        $inputData = json_encode($symptomsObj);

        // Send request to the Python Flask API
        $client = new Client();
        $response = $client->post('http://127.0.0.1:5050/predict', [
            'json' => $inputData
        ]);

        // Decode the response from the Python API
        $result = json_decode($response->getBody()->getContents(), true);

        // Return the prediction result
        $resultObject = json_decode(json_encode($result));
        // dd($resultObject);
        return view('sistem-pakar.process', [
            'step' => 3,
            'user_id' => $request->user_id,
            'result' => $resultObject
        ]);

    }

    private function getEngName($indName)
    {
        $allSymptoms = [
            'gatal' => 'itching',
            'ruam kulit' => 'skin_rash',
            'erupsi kulit nodular' => 'nodal_skin_eruptions',
            'bersin terus-menerus' => 'continuous_sneezing',
            'menggigil' => 'shivering',
            'demam dingin' => 'chills',
            'nyeri sendi' => 'joint_pain',
            'sakit perut' => 'stomach_pain',
            'asam lambung' => 'acidity',
            'luka di lidah' => 'ulcers_on_tongue',
            'pengikisan otot' => 'muscle_wasting',
            'muntah' => 'vomiting',
            'nyeri saat buang air kecil' => 'burning_micturition',
            'kelelahan' => 'fatigue',
            'penambahan berat badan' => 'weight_gain',
            'kecemasan' => 'anxiety',
            'tangan dan kaki dingin' => 'cold_hands_and_feets',
            'perubahan suasana hati' => 'mood_swings',
            'penurunan berat badan' => 'weight_loss',
            'gelisah' => 'restlessness',
            'lesu' => 'lethargy',
            'bercak di tenggorokan' => 'patches_in_throat',
            'gula darah tidak teratur' => 'irregular_sugar_level',
            'batuk' => 'cough',
            'demam tinggi' => 'high_fever',
            'mata cekung' => 'sunken_eyes',
            'sesak napas' => 'breathlessness',
            'keringat berlebih' => 'sweating',
            'dehidrasi' => 'dehydration',
            'gangguan pencernaan' => 'indigestion',
            'sakit kepala' => 'headache',
            'kulit menguning' => 'yellowish_skin',
            'urine gelap' => 'dark_urine',
            'mual' => 'nausea',
            'hilang nafsu makan' => 'loss_of_appetite',
            'nyeri di belakang mata' => 'pain_behind_the_eyes',
            'nyeri punggung' => 'back_pain',
            'sembelit' => 'constipation',
            'nyeri perut' => 'abdominal_pain',
            'diare' => 'diarrhoea',
            'demam ringan' => 'mild_fever',
            'urine kuning' => 'yellow_urine',
            'mata menguning' => 'yellowing_of_eyes',
            'gagal hati akut' => 'acute_liver_failure',
            'kelebihan cairan' => 'fluid_overload',
            'perut bengkak' => 'swelling_of_stomach',
            'pembengkakan kelenjar getah bening' => 'swelled_lymph_nodes',
            'lemas' => 'malaise',
            'penglihatan kabur dan terdistorsi' => 'blurred_and_distorted_vision',
            'dahak' => 'phlegm',
            'iritasi tenggorokan' => 'throat_irritation',
            'mata merah' => 'redness_of_eyes',
            'tekanan sinus' => 'sinus_pressure',
            'hidung berair' => 'runny_nose',
            'hidung tersumbat' => 'congestion',
            'nyeri dada' => 'chest_pain',
            'kelemahan anggota tubuh' => 'weakness_in_limbs',
            'detak jantung cepat' => 'fast_heart_rate',
            'nyeri saat buang air besar' => 'pain_during_bowel_movements',
            'nyeri di area anus' => 'pain_in_anal_region',
            'tinja berdarah' => 'bloody_stool',
            'iritasi di anus' => 'irritation_in_anus',
            'nyeri leher' => 'neck_pain',
            'pusing' => 'dizziness',
            'kram' => 'cramps',
            'memar' => 'bruising',
            'obesitas' => 'obesity',
            'kaki bengkak' => 'swollen_legs',
            'pembuluh darah bengkak' => 'swollen_blood_vessels',
            'wajah dan mata bengkak' => 'puffy_face_and_eyes',
            'kelenjar tiroid membesar' => 'enlarged_thyroid',
            'kuku rapuh' => 'brittle_nails',
            'anggota tubuh bengkak' => 'swollen_extremeties',
            'rasa lapar berlebihan' => 'excessive_hunger',
            'hubungan di luar nikah' => 'extra_marital_contacts',
            'bibir kering dan kesemutan' => 'drying_and_tingling_lips',
            'bicara pelo' => 'slurred_speech',
            'nyeri lutut' => 'knee_pain',
            'nyeri sendi panggul' => 'hip_joint_pain',
            'kelemahan otot' => 'muscle_weakness',
            'leher kaku' => 'stiff_neck',
            'persendian bengkak' => 'swelling_joints',
            'kaku gerak' => 'movement_stiffness',
            'gerakan berputar' => 'spinning_movements',
            'kehilangan keseimbangan' => 'loss_of_balance',
            'tidak stabil' => 'unsteadiness',
            'kelemahan satu sisi tubuh' => 'weakness_of_one_body_side',
            'kehilangan penciuman' => 'loss_of_smell',
            'ketidaknyamanan kandung kemih' => 'bladder_discomfort',
            'terus merasa ingin buang air kecil' => 'continuous_feel_of_urine',
            'buang gas' => 'passage_of_gases',
            'gatal dari dalam tubuh' => 'internal_itching',
            'wajah keracunan (tifus)' => 'toxic_look_(typhos)',
            'depresi' => 'depression',
            'mudah marah' => 'irritability',
            'nyeri otot' => 'muscle_pain',
            'kesadaran terganggu' => 'altered_sensorium',
            'bintik merah di tubuh' => 'red_spots_over_body',
            'nyeri perut bagian bawah' => 'belly_pain',
            'menstruasi tidak normal' => 'abnormal_menstruation',
            'air mata keluar berlebihan' => 'watering_from_eyes',
            'nafsu makan meningkat' => 'increased_appetite',
            'banyak buang air kecil' => 'polyuria',
            'riwayat keluarga' => 'family_history',
            'dahak kental' => 'mucoid_sputum',
            'dahak berkarat' => 'rusty_sputum',
            'kurang konsentrasi' => 'lack_of_concentration',
            'gangguan penglihatan' => 'visual_disturbances',
            'menerima transfusi darah' => 'receiving_blood_transfusion',
            'menerima suntikan tidak steril' => 'receiving_unsterile_injections',
            'koma' => 'coma',
            'pendarahan lambung' => 'stomach_bleeding',
            'perut membesar' => 'distention_of_abdomen',
            'riwayat konsumsi alkohol' => 'history_of_alcohol_consumption',
            'darah di dahak' => 'blood_in_sputum',
            'pembuluh vena betis menonjol' => 'prominent_veins_on_calf',
            'jantung berdebar' => 'palpitations',
            'nyeri saat berjalan' => 'painful_walking',
            'jerawat bernanah' => 'pus_filled_pimples',
            'komedo' => 'blackheads',
            'bekas luka' => 'scurring',
            'kulit mengelupas' => 'skin_peeling',
            'serpihan seperti perak' => 'silver_like_dusting',
            'cekungan kecil di kuku' => 'small_dents_in_nails',
            'peradangan kuku' => 'inflammatory_nails',
            'lepuh' => 'blister',
            'luka merah di sekitar hidung' => 'red_sore_around_nose',
            'kerak kuning mengalir' => 'yellow_crust_ooze',
            'prognosis' => 'prognosis',
            'urine berbau menyengat' => 'foul smell of urine',
            'timbul jerawat bernanah' => 'pus filled pimples',
            'hilangnya konsentrasi' => 'lack of concentration',
        ];
        $engName = $allSymptoms[$indName] ?? null;
        if ($engName) {
            return $engName;
        } else {
            return null;
        }
    }
}
