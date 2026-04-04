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
   public function index(\Illuminate\Http\Request $request)
    {
        // كنقلبو واش كاين شي كلمة تتبحث عليها السكريتيرة
        $search = $request->input('search');

        if ($search) {
            // إلا كليكات على بحث، كنجيبو غير اللي فيهم ديك السمية أو الكنية أو CIN
            $patients = \App\Models\Patient::where('nom', 'LIKE', "%{$search}%")
                                ->orWhere('prenom', 'LIKE', "%{$search}%")
                                ->orWhere('cin', 'LIKE', "%{$search}%")
                                ->get();
        } else {
            // إلا ماكاتقلب على والو، كنجيبو كلشي
            $patients = \App\Models\Patient::all();
        }

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
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'nullable|string|max:20|unique:patients', // الـ CIN خاصو يكون ما معاودش
            'telephone' => 'required|string|max:20',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:Homme,Femme',
            'adresse' => 'nullable|string',
        ]);

        // تسجيل المريض فـ قاعدة البيانات
        Patient::create($request->all());

        // الرجوع لصفحة اللائحة مع رسالة نجاح
        return redirect()->route('patients.index')->with('success', 'Le patient a été ajouté avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // كنقلبو على المريض بالـ ID ديالو
        $patient = \App\Models\Patient::findOrFail($id);

        // كنصيفطو هاد المريض لواحد الصفحة سميتها show باش تبين المعلومات ديالو
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $patient = \App\Models\Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validation: كنتأكدو من المعلومات (رد البال لـ CIN باش ما يعطيش إيرور إذا بقى هو هو)
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cin' => 'nullable|string|max:20|unique:patients,cin,'.$id, // كنستثنيو المريض الحالي من الفحص ديال CIN
            'telephone' => 'required|string|max:20',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:Homme,Femme',
            'adresse' => 'nullable|string',
        ]);

        // 2. كنقلبو على المريض وكنبدلو ليه الداتا
        $patient = \App\Models\Patient::findOrFail($id);
        $patient->update($request->all());

        // 3. كنرجعو للائحة مع ميساج ديال النجاح
        return redirect()->route('patients.index')->with('success', 'Les informations du patient ont été mises à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // 1. كنقلبو على المريض بالـ ID ديالو
        $patient = \App\Models\Patient::findOrFail($id);

        // 2. كمسحوه من لاباز دوني
        $patient->delete();

        // 3. كنرجعو للصفحة اللولة مع ميساج بلي راه تمسح
        return redirect()->route('patients.index')->with('success', 'Le patient a été supprimé avec succès !');
    }
}
