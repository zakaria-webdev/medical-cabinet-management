<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // جلب كاع المرضى من لاباز دوني
        $patients = Patient::all();

        // صيفطهم لواحد الصفحة سميتها index كاينا فدوسي patients
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // التحقق من البيانات (Validation)
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'telephone' => 'required',
            'date_naissance' => 'required|date',
            'sexe' => 'required',
        ]);

        // تسجيل المريض فـ قاعدة البيانات
        Patient::create($request->all());

        // الرجوع لصفحة اللائحة مع رسالة نجاح
        return redirect()->route('patients.index')->with('success', 'Le patient a été ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
