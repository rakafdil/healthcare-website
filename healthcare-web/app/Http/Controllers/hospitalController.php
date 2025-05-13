<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class hospitalController extends Controller
{
    // Add this method to show hospital details
    public function showHospitalDetail($id)
    {
        // Fetch hospital details by ID from your database
        // For now, return a placeholder view
        return view('hospital_detail', ['hospital_id' => $id]);
    }

    // Optional: Add a method to mock capacity data if you don't have real data
    public function getHospitalCapacity($placeId)
    {
        // In a real application, fetch this from your database
        // For now, return random values
        $available = rand(10, 40);
        $total = $available + rand(40, 60);
        
        return [
            'available' => $available,
            'total' => $total
        ];
    }
}