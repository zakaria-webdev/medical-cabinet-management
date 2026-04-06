<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DossierMedical;
use App\Models\Patient;

class DossierMedicalController extends Controller
{
    // 1. عرض لائحة الملفات الطبية
    public function index()
    {
        $dossiers = DossierMedical::with('patient')->get();
        return view('dossiers.index', compact('dossiers'));
    }

    // 2. فتح صفحة إضافة ملف طبي جديد
    public function create()
    {
        $patients = Patient::doesntHave('dossierMedical')->get();
        return view('dossiers.create', compact('patients'));
    }

    // 3. تسجيل الملف الطبي فـ لاباز دوني
    public function store(Request $request)
    {
        $request->validate([
            // هنا بدلنا dossiers_medicaux بـ dossier_medicals باش تطابق لاباز دوني
            'patient_id' => 'required|exists:patients,id|unique:dossier_medicals,patient_id',
            'groupe_sanguin' => 'nullable|string|max:5',
            'allergies' => 'nullable|string',
            'maladies_chroniques' => 'nullable|string',
            'operations_chirurgicales' => 'nullable|string',
            'traitement_en_cours' => 'nullable|string',
        ]);

        DossierMedical::create($request->all());

        return redirect()->route('dossiers.index')->with('success', 'Le dossier médical a été créé avec succès !');
    }

    // 4. عرض تفاصيل ملف طبي واحد (Show)
    public function show($id)
    {
        $dossier = DossierMedical::with('patient')->findOrFail($id);
        return view('dossiers.show', compact('dossier'));
    }

    // 5. فتح صفحة التعديل (Edit)
    public function edit($id)
    {
        $dossier = DossierMedical::findOrFail($id);
        return view('dossiers.edit', compact('dossier'));
    }

    // 6. تسجيل التعديلات (Update)
    public function update(Request $request, $id)
    {
        $dossier = DossierMedical::findOrFail($id);

        $request->validate([
            'groupe_sanguin' => 'nullable|string|max:5',
            'allergies' => 'nullable|string',
            'maladies_chroniques' => 'nullable|string',
            'operations_chirurgicales' => 'nullable|string',
            'traitement_en_cours' => 'nullable|string',
        ]);

        // كنديرو except لـ patient_id باش حتى واحد مايقدر يبدلو فالتعديل بالخطأ
        $dossier->update($request->except(['patient_id']));

        return redirect()->route('dossiers.index')->with('success', 'Le dossier médical a été mis à jour avec succès !');
    }

    // 7. مسح الملف الطبي (Destroy)
    public function destroy($id)
    {
        $dossier = DossierMedical::findOrFail($id);
        $dossier->delete();

        return redirect()->route('dossiers.index')->with('success', 'Le dossier médical a été supprimé.');
    }
}
