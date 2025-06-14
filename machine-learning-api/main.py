from flask import Flask, request, jsonify
import pickle
import numpy as np
import pandas as pd
import json
import math

def sanitize(data):
    if isinstance(data, dict):
        return {k: sanitize(v) for k, v in data.items()}
    elif isinstance(data, list):
        return [sanitize(v) for v in data]
    elif isinstance(data, float) and math.isnan(data):
        return None
    return data

with open("machine-learning-api/symptom_index.json") as f:
    symptoms = json.load(f)

# Load the model
model = pickle.load(open('machine-learning-api/ExtraTrees.pkl', 'rb'))

diseases = [
    '(vertigo) Paroymsal Positional Vertigo', 'AIDS', 'Acne', 'Alcoholic hepatitis', 'Allergy', 
    'Arthritis', 'Bronchial Asthma', 'Cervical spondylosis', 'Chicken pox', 'Chronic cholestasis', 
    'Common Cold', 'Dengue', 'Diabetes', 'Dimorphic hemmorhoids(piles)', 'Drug Reaction', 
    'Fungal infection', 'GERD', 'Gastroenteritis', 'Heart attack', 'Hepatitis B', 'Hepatitis C', 
    'Hepatitis D', 'Hepatitis E', 'Hypertension', 'Hyperthyroidism', 'Hypoglycemia', 'Hypothyroidism', 
    'Impetigo', 'Jaundice', 'Malaria', 'Migraine', 'Osteoarthristis', 'Paralysis (brain hemorrhage)', 
    'Peptic ulcer diseae', 'Pneumonia', 'Psoriasis', 'Tuberculosis', 'Typhoid', 
    'Urinary tract infection', 'Varicose veins', 'hepatitis A'
]

diseases_translated = {
    "(vertigo) Paroymsal Positional Vertigo": "Vertigo Posisi",
    "AIDS": "AIDS",
    "Acne": "Jerawat",
    "Alcoholic hepatitis": "Hepatitis Alkoholik",
    "Allergy": "Alergi",
    "Arthritis": "Artritis",
    "Bronchial Asthma": "Asma Bronkial",
    "Cervical spondylosis": "Spondilosis Serviks",
    "Chicken pox": "Cacar Air",
    "Chronic cholestasis": "Kolestasis Kronis",
    "Common Cold": "Flu Biasa",
    "Dengue": "Demam Berdarah",
    "Diabetes": "Diabetes",
    "Dimorphic hemmorhoids(piles)": "Ambeien",
    "Drug Reaction": "Reaksi Obat",
    "Fungal infection": "Infeksi Jamur",
    "GERD": "GERD",
    "Gastroenteritis": "Gastroenteritis",
    "Heart attack": "Serangan Jantung",
    "Hepatitis B": "Hepatitis B",
    "Hepatitis C": "Hepatitis C",
    "Hepatitis D": "Hepatitis D",
    "Hepatitis E": "Hepatitis E",
    "Hypertension": "Hipertensi",
    "Hyperthyroidism": "Hipertiroidisme",
    "Hypoglycemia": "Hipoglikemia",
    "Hypothyroidism": "Hipotiroidisme",
    "Impetigo": "Impetigo",
    "Jaundice": "Penyakit Kuning",
    "Malaria": "Malaria",
    "Migraine": "Migrain",
    "Osteoarthristis": "Osteoartritis",
    "Paralysis (brain hemorrhage)": "Kelumpuhan (Perdarahan Otak)",
    "Peptic ulcer diseae": "Penyakit Tukak Lambung",
    "Pneumonia": "Pneumonia",
    "Psoriasis": "Psoriasis",
    "Tuberculosis": "Tuberkulosis",
    "Typhoid": "Tifoid",
    "Urinary tract infection": "Infeksi Saluran Kemih",
    "Varicose veins": "Varises",
    "hepatitis A": "Hepatitis A"
}



print(len(symptoms))
desc=pd.read_csv("machine-learning-api/symptoms-datasets/symptom_Description.csv")
prec=pd.read_csv("machine-learning-api/symptoms-datasets/symptom_precaution.csv")
app = Flask(__name__)


@app.route('/', methods=["GET"])
def home():
    return app.send_static_file('index.html')

@app.route('/predict', methods=['POST'])
def predict():
    features=pd.Series([0]*131, index=symptoms)
    print(len(features))
    # Parse the JSON input
    data = request.get_json(force=True)
    print("Received symptoms:", data)

    # Set features to 1 where symptoms are present
    for symptom in data:
        if symptom in features.index:
            features[symptom] = 1

    # Convert to NumPy and reshape
    features = features.to_numpy().reshape(1, -1)
    print("Feature vector:", features.tolist())

    # Predict probabilities
    proba = model.predict_proba(features)

    # Top 5 predicted classes and their probabilities
    top5_idx = np.argsort(proba[0])[-5:][::-1]
    top5_proba = np.sort(proba[0])[-5:][::-1]
    top5_diseases_eng = [diseases[i] for i in top5_idx]
    top5_diseases = [diseases_translated[diseases[i]] for i in top5_idx]
    
    # Build response
    response = []
    for i in range(5):
        disease = top5_diseases[i]
        disease_eng = top5_diseases_eng[i]
        probability = float(top5_proba[i])
        
        # Disease description
        disp = desc[desc['Disease'] == disease].values[0][1] if disease in desc["Disease"].unique() else "No description available"
        
        # Precautions
        precautions = []
        if disease in prec["Disease"].unique():
            c = np.where(prec['Disease'] == disease)[0][0]
            for j in range(1, len(prec.iloc[c])):
                precautions.append(prec.iloc[c, j])
        print(disease, probability, disp, precautions)
        # Add to response
        response.append({
            'disease': disease_eng,
            'probability': probability,
            'description': disp,
            'precautions': precautions
        })
    clean_result = sanitize(response)
    return jsonify(clean_result)


if __name__ == '__main__':
    app.run(port=5050, debug=True, use_reloader=False)
