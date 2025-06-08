<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gejala;

class GejalaSeeder extends Seeder
{
    public function run()
    {
        $diseases = [
            'Gatal' => 'itching',
            'Ruam kulit' => 'skin_rash',
            'Benjolan pada kulit' => 'nodal_skin_eruptions',
            'Bersin terus menerus' => 'continuous_sneezing',
            'Menggigil' => 'shivering',
            'Meriang' => 'chills',
            'Nyeri sendi' => 'joint_pain',
            'Sakit perut' => 'stomach_pain',
            'Asam lambung' => 'acidity',
            'Sariawan atau luka di lidah' => 'ulcers_on_tongue',
            'Penyusutan otot' => 'muscle_wasting',
            'Muntah' => 'vomiting',
            'Nyeri atau rasa terbakar saat buang air kecil' => 'burning_micturition',
            'Bercak darah saat buang air kecil' => 'spotting_urination',
            'Kelelahan' => 'fatigue',
            'Penambahan berat badan' => 'weight_gain',
            'Kecemasan atau cemas' => 'anxiety',
            'Tangan dan kaki dingin' => 'cold_hands_and_feets',
            'Perubahan suasana hati' => 'mood_swings',
            'Penurunan berat badan' => 'weight_loss',
            'Gelisah' => 'restlessness',
            'Lemas / tidak bertenaga' => 'lethargy',
            'Bercak putih di tenggorokan' => 'patches_in_throat',
            'Kadar gula darah tidak teratur' => 'irregular_sugar_level',
            'Batuk' => 'cough',
            'Demam tinggi' => 'high_fever',
            'Mata cekung / tampak dalam' => 'sunken_eyes',
            'Sesak napas' => 'breathlessness',
            'Keringat berlebihan' => 'sweating',
            'Dehidrasi' => 'dehydration',
            'Gangguan pencernaan' => 'indigestion',
            'Sakit kepala' => 'headache',
            'Kulit menguning' => 'yellowish_skin',
            'Urin berwarna gelap' => 'dark_urine',
            'Mual' => 'nausea',
            'Hilang nafsu makan' => 'loss_of_appetite',
            'Sakit di belakang mata' => 'pain_behind_the_eyes',
            'Sakit punggung' => 'back_pain',
            'Sembelit' => 'constipation',
            'Sakit perut bagian bawah' => 'abdominal_pain',
            'Diare' => 'diarrhoea',
            'Demam ringan' => 'mild_fever',
            'Urin kuning' => 'yellow_urine',
            'Mata menguning' => 'yellowing_of_eyes',
            'Gagal fungsi hati akut' => 'acute_liver_failure',
            'Kelebihan cairan' => 'fluid_overload',
            'Perut bengkak' => 'swelling_of_stomach',
            'Pembengkakan kelenjar getah bening' => 'swelled_lymph_nodes',
            'Tidak enak badan' => 'malaise',
            'Penglihatan buram dan terdistorsi' => 'blurred_and_distorted_vision',
            'Dahak' => 'phlegm',
            'Iritasi tenggorokan' => 'throat_irritation',
            'Kemerahan pada mata' => 'redness_of_eyes',
            'Tekanan sinus' => 'sinus_pressure',
            'Hidung meler/ingus berlebihan' => 'runny_nose',
            'Hidung tersumbat' => 'congestion',
            'Nyeri dada' => 'chest_pain',
            'Kelemahan anggota tubuh seperti tangan dan kaki' => 'weakness_in_limbs',
            'Detak jantung cepat' => 'fast_heart_rate',
            'Nyeri saat buang air besar' => 'pain_during_bowel_movements',
            'Nyeri di daerah anus' => 'pain_in_anal_region',
            'Tinja berdarah' => 'bloody_stool',
            'Iritasi di anus' => 'irritation_in_anus',
            'Sakit leher' => 'neck_pain',
            'Pusing' => 'dizziness',
            'Kram' => 'cramps',
            'Memar' => 'bruising',
            'Obesitas' => 'obesity',
            'Kaki bengkak' => 'swollen_legs',
            'Pembuluh darah bengkak' => 'swollen_blood_vessels',
            'Wajah dan mata bengkak' => 'puffy_face_and_eyes',
            'Pembesaran tiroid' => 'enlarged_thyroid',
            'Kuku rapuh' => 'brittle_nails',
            'Ekstremitas bengkak' => 'swollen_extremeties',
            'Lapar berlebihan' => 'excessive_hunger',
            'Kontak di luar pernikahan' => 'extra_marital_contacts',
            'Bibir kering dan kesemutan' => 'drying_and_tingling_lips',
            'Bicara pelo/tidak jelas' => 'slurred_speech',
            'Nyeri lutut' => 'knee_pain',
            'Nyeri sendi pinggul' => 'hip_joint_pain',
            'Kelemahan otot' => 'muscle_weakness',
            'Leher kaku' => 'stiff_neck',
            'Sendi bengkak' => 'swelling_joints',
            'Kekakuan gerakan' => 'movement_stiffness',
            'Merasa seperti berputar' => 'spinning_movements',
            'Kehilangan keseimbangan' => 'loss_of_balance',
            'Ketidakstabilan' => 'unsteadiness',
            'Kelemahan satu sisi tubuh' => 'weakness_of_one_body_side',
            'Kehilangan penciuman' => 'loss_of_smell',
            'Ketidaknyamanan kandung kemih' => 'bladder_discomfort',
            'Bau urin tidak sedap' => 'foul_smell_ofurine',
            'Rasa ingin buang air kecil terus menerus' => 'continuous_feel_of_urine',
            'Keluar gas' => 'passage_of_gases',
            'Gatal dari dalam' => 'internal_itching',
            'Wajah tampak sakit atau toksik (tifus)' => 'toxic_look_(typhos)',
            'Depresi' => 'depression',
            'Mudah marah' => 'irritability',
            'Nyeri otot' => 'muscle_pain',
            'Kesadaran terganggu' => 'altered_sensorium',
            'Bintik merah di tubuh' => 'red_spots_over_body',
            'Sakit di seluruh area perut' => 'belly_pain',
            'Menstruasi tidak normal' => 'abnormal_menstruation',
            'Bercak warna kulit tidak merata' => 'dischromic_patches',
            'Mata berair' => 'watering_from_eyes',
            'Nafsu makan meningkat' => 'increased_appetite',
            'Sering buang air kecil' => 'polyuria',
            'Riwayat keluarga' => 'family_history',
            'Dahak berlendir' => 'mucoid_sputum',
            'Dahak berwarna merah atau seperti karat' => 'rusty_sputum',
            'Kurang atau sulit konsentrasi' => 'lack_of_concentration',
            'Gangguan penglihatan' => 'visual_disturbances',
            'Menerima transfusi darah' => 'receiving_blood_transfusion',
            'Menerima suntikan tidak steril' => 'receiving_unsterile_injections',
            'Koma' => 'coma',
            'Perdarahan lambung' => 'stomach_bleeding',
            'Perut kembung' => 'distention_of_abdomen',
            'Riwayat atau pernah konsumsi alkohol' => 'history_of_alcohol_consumption',
            'Darah dalam dahak' => 'blood_in_sputum',
            'Pembuluh darah betis menonjol' => 'prominent_veins_on_calf',
            'Jantung berdebar' => 'palpitations',
            'Nyeri saat berjalan' => 'painful_walking',
            'Jerawat bernanah' => 'pus_filled_pimples',
            'Komedo' => 'blackheads',
            'Kerak kulit' => 'scurring',
            'Kulit mengelupas' => 'skin_peeling',
            'Kulit muuncul debu seperti debu perak' => 'silver_like_dusting',
            'Lekukan kecil di kuku' => 'small_dents_in_nails',
            'Kuku meradang' => 'inflammatory_nails',
            'Lepuhan' => 'blister',
            'Luka merah di sekitar hidung' => 'red_sore_around_nose',
            'Kerak kuning yang keluar' => 'yellow_crust_ooze',
        ];

        $grouped_symptoms = [
            'Gejala Umum & Sistemik' => [
                'Demam tinggi' => 'high_fever',
                'Demam ringan' => 'mild_fever',
                'Meriang' => 'chills',
                'Menggigil' => 'shivering',
                'Kelelahan' => 'fatigue',
                'Lemas / tidak bertenaga' => 'lethargy',
                'Tidak enak badan' => 'malaise',
                'Keringat berlebihan' => 'sweating'
            ],

            'Sistem Saraf & Neurologis' => [
                'Sakit kepala' => 'headache',
                'Pusing' => 'dizziness',
                'Kesadaran terganggu' => 'altered_sensorium',
                'Bicara pelo/tidak jelas' => 'slurred_speech',
                'Kelemahan satu sisi tubuh' => 'weakness_of_one_body_side',
                'Kehilangan keseimbangan' => 'loss_of_balance',
                'Ketidakstabilan' => 'unsteadiness',
                'Merasa seperti berputar' => 'spinning_movements',
                'Kurang atau sulit konsentrasi' => 'lack_of_concentration',
                'Koma' => 'coma'
            ],

            'Sistem Kardiovaskular' => [
                'Nyeri dada' => 'chest_pain',
                'Detak jantung cepat' => 'fast_heart_rate',
                'Jantung berdebar' => 'palpitations',
                'Kaki bengkak' => 'swollen_legs',
                'Pembuluh darah bengkak' => 'swollen_blood_vessels',
                'Ekstremitas bengkak' => 'swollen_extremeties',
                'Pembuluh darah betis menonjol' => 'prominent_veins_on_calf'
            ],

            'Sistem Pernapasan' => [
                'Batuk' => 'cough',
                'Sesak napas' => 'breathlessness',
                'Dahak' => 'phlegm',
                'Dahak berlendir' => 'mucoid_sputum',
                'Dahak berwarna merah atau seperti karat' => 'rusty_sputum',
                'Darah dalam dahak' => 'blood_in_sputum',
                'Hidung meler/ingus berlebihan' => 'runny_nose',
                'Hidung tersumbat' => 'congestion',
                'Bersin terus menerus' => 'continuous_sneezing',
                'Iritasi tenggorokan' => 'throat_irritation',
                'Tekanan sinus' => 'sinus_pressure',
                'Bercak putih di tenggorokan' => 'patches_in_throat'
            ],

            'Sistem Pencernaan' => [
                'Mual' => 'nausea',
                'Muntah' => 'vomiting',
                'Sakit perut' => 'stomach_pain',
                'Sakit perut bagian bawah' => 'abdominal_pain',
                'Sakit di seluruh area perut' => 'belly_pain',
                'Asam lambung' => 'acidity',
                'Gangguan pencernaan' => 'indigestion',
                'Diare' => 'diarrhoea',
                'Sembelit' => 'constipation',
                'Hilang nafsu makan' => 'loss_of_appetite',
                'Nafsu makan meningkat' => 'increased_appetite',
                'Lapar berlebihan' => 'excessive_hunger',
                'Perut bengkak' => 'swelling_of_stomach',
                'Perut kembung' => 'distention_of_abdomen',
                'Keluar gas' => 'passage_of_gases',
                'Perdarahan lambung' => 'stomach_bleeding'
            ],

            'Sistem Urinari' => [
                'Nyeri atau rasa terbakar saat buang air kecil' => 'burning_micturition',
                'Bercak darah saat buang air kecil' => 'spotting_urination',
                'Urin berwarna gelap' => 'dark_urine',
                'Urin kuning' => 'yellow_urine',
                'Bau urin tidak sedap' => 'foul_smell_ofurine',
                'Sering buang air kecil' => 'polyuria',
                'Rasa ingin buang air kecil terus menerus' => 'continuous_feel_of_urine',
                'Ketidaknyamanan kandung kemih' => 'bladder_discomfort'
            ],

            'Sistem Muskuloskeletal' => [
                'Nyeri sendi' => 'joint_pain',
                'Nyeri lutut' => 'knee_pain',
                'Nyeri sendi pinggul' => 'hip_joint_pain',
                'Sakit punggung' => 'back_pain',
                'Sakit leher' => 'neck_pain',
                'Nyeri otot' => 'muscle_pain',
                'Kelemahan otot' => 'muscle_weakness',
                'Penyusutan otot' => 'muscle_wasting',
                'Kelemahan anggota tubuh seperti tangan dan kaki' => 'weakness_in_limbs',
                'Leher kaku' => 'stiff_neck',
                'Sendi bengkak' => 'swelling_joints',
                'Kekakuan gerakan' => 'movement_stiffness',
                'Kram' => 'cramps',
                'Nyeri saat berjalan' => 'painful_walking'
            ],

            'Mata & Penglihatan' => [
                'Mata cekung / tampak dalam' => 'sunken_eyes',
                'Sakit di belakang mata' => 'pain_behind_the_eyes',
                'Mata menguning' => 'yellowing_of_eyes',
                'Kemerahan pada mata' => 'redness_of_eyes',
                'Penglihatan buram dan terdistorsi' => 'blurred_and_distorted_vision',
                'Gangguan penglihatan' => 'visual_disturbances',
                'Wajah dan mata bengkak' => 'puffy_face_and_eyes',
                'Mata berair' => 'watering_from_eyes'
            ],

            'Kulit & Dermatologi' => [
                'Gatal' => 'itching',
                'Gatal dari dalam' => 'internal_itching',
                'Ruam kulit' => 'skin_rash',
                'Benjolan pada kulit' => 'nodal_skin_eruptions',
                'Kulit menguning' => 'yellowish_skin',
                'Bintik merah di tubuh' => 'red_spots_over_body',
                'Bercak warna kulit tidak merata' => 'dischromic_patches',
                'Kulit mengelupas' => 'skin_peeling',
                'Kulit muuncul debu seperti debu perak' => 'silver_like_dusting',
                'Kerak kulit' => 'scurring',
                'Lepuhan' => 'blister',
                'Luka merah di sekitar hidung' => 'red_sore_around_nose',
                'Kerak kuning yang keluar' => 'yellow_crust_ooze',
                'Jerawat bernanah' => 'pus_filled_pimples',
                'Komedo' => 'blackheads'
            ],

            'Kuku' => [
                'Kuku rapuh' => 'brittle_nails',
                'Lekukan kecil di kuku' => 'small_dents_in_nails',
                'Kuku meradang' => 'inflammatory_nails'
            ],

            'Sistem Hematologi & Pendarahan' => [
                'Memar' => 'bruising',
                'Tinja berdarah' => 'bloody_stool',
                'Nyeri saat buang air besar' => 'pain_during_bowel_movements',
                'Nyeri di daerah anus' => 'pain_in_anal_region',
                'Iritasi di anus' => 'irritation_in_anus'
            ],

            'Sistem Endokrin & Metabolik' => [
                'Kadar gula darah tidak teratur' => 'irregular_sugar_level',
                'Penambahan berat badan' => 'weight_gain',
                'Penurunan berat badan' => 'weight_loss',
                'Obesitas' => 'obesity',
                'Pembesaran tiroid' => 'enlarged_thyroid',
                'Dehidrasi' => 'dehydration'
            ],

            'Kesehatan Mental & Psikologis' => [
                'Kecemasan atau cemas' => 'anxiety',
                'Perubahan suasana hati' => 'mood_swings',
                'Gelisah' => 'restlessness',
                'Depresi' => 'depression',
                'Mudah marah' => 'irritability'
            ],

            'Gejala Khusus & Lainnya' => [
                'Tangan dan kaki dingin' => 'cold_hands_and_feets',
                'Sariawan atau luka di lidah' => 'ulcers_on_tongue',
                'Pembengkakan kelenjar getah bening' => 'swelled_lymph_nodes',
                'Gagal fungsi hati akut' => 'acute_liver_failure',
                'Kelebihan cairan' => 'fluid_overload',
                'Kehilangan penciuman' => 'loss_of_smell',
                'Wajah tampak sakit atau toksik (tifus)' => 'toxic_look_(typhos)',
                'Bibir kering dan kesemutan' => 'drying_and_tingling_lips',
                'Menstruasi tidak normal' => 'abnormal_menstruation'
            ],

            'Riwayat & Faktor Risiko' => [
                'Riwayat keluarga' => 'family_history',
                'Menerima transfusi darah' => 'receiving_blood_transfusion',
                'Menerima suntikan tidak steril' => 'receiving_unsterile_injections',
                'Riwayat atau pernah konsumsi alkohol' => 'history_of_alcohol_consumption',
                'Kontak di luar pernikahan' => 'extra_marital_contacts'
            ]
        ];


        foreach ($grouped_symptoms as $group_name => $symptoms) {
            foreach ($symptoms as $ind => $eng) {
                Gejala::create([
                    'nama_gejala_ind' => $ind,
                    'nama_gejala_eng' => $eng,
                    'tipe' => $group_name
                ]);
            }
        }
    }
}

