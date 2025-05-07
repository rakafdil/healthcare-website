<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Diagnosis;

class DiagnosisSeeder extends Seeder
{
    public function run()
    {
        $diseases = [
            "Acne" => "Jerawat",
            "Hyperthyroidism" => "Hipertiroidisme",
            "AIDS" => "AIDS",
            "Chronic cholestasis" => "Kolestasis kronis",
            "Hypertension" => "Hipertensi (tekanan darah tinggi)",
            "Hypoglycemia" => "Hipoglikemia (gula darah rendah)",
            "Arthritis" => "Radang sendi (Artritis)",
            "Hepatitis B" => "Hepatitis B",
            "Migraine" => "Migrain",
            "Urinary tract infection" => "Infeksi saluran kemih",
            "Diabetes" => "Diabetes",
            "Hepatitis D" => "Hepatitis D",
            "Psoriasis" => "Psoriasis",
            "Alcoholic hepatitis" => "Hepatitis akibat alkohol",
            "Dimorphic hemmorhoids(piles)" => "Wasir dimorfik",
            "Hepatitis E" => "Hepatitis E",
            "Cervical spondylosis" => "Spondilosis servikal",
            "Bronchial Asthma" => "Asma bronkial",
            "hepatitis A" => "Hepatitis A",
            "Allergy" => "Alergi",
            "Hepatitis C" => "Hepatitis C",
            "Pneumonia" => "Pneumonia (radang paru-paru)",
            "Hypothyroidism" => "Hipotiroidisme",
            "Gastroenteritis" => "Gastroenteritis",
            "Varicose veins" => "Varises",
            "Jaundice" => "Penyakit kuning",
            "Drug Reaction" => "Reaksi obat",
            "(vertigo) Paroymsal  Positional Vertigo" => "Vertigo posisi paroksismal (BPPV)",
            "Heart attack" => "Serangan jantung",
            "Tuberculosis" => "Tuberkulosis (TBC)",
            "Typhoid" => "Tifoid (demam tifus)",
            "Common Cold" => "Masuk angin / Pilek",
            "Peptic ulcer diseae" => "Penyakit tukak lambung",
            "Paralysis (brain hemorrhage)" => "Kelumpuhan (perdarahan otak)",
            "Fungal infection" => "Infeksi jamur",
            "Impetigo" => "Impetigo",
            "GERD" => "GERD (refluks asam lambung)",
            "Dengue" => "Demam berdarah",
            "Malaria" => "Malaria",
            "Chicken pox" => "Cacar air",
            "Osteoarthristis" => "Osteoartritis",
        ];

        foreach ($diseases as $en => $id) {
            Diagnosis::create([
                'name_en' => $en,
                'name_id' => $id,
            ]);
        }
    }
}

