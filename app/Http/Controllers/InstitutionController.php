<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\Employee;
use Illuminate\Http\Request;



class InstitutionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Institution::class, 'institution');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $institution = Institution::with('employees')->find(1);
        // dd($institution->employees);

        $institutions = Institution::with('kepala')->paginate(10);
        return view('institution.index', compact('institutions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = collect();
        return view('institution.create_institution', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'pemerintah' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'alias' => 'required|string|max:255',
            'kepala_instansi_id' => 'nullable|exists:employees,id',

        ], [
            'nama.required' => 'Nama instansi wajib diisi.',
            'pemerintah.required' => 'Nama pemerintah wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'kepala_instansi_id.exists' => 'Kepala instansi tidak ditemukan.',


        ]);
        if ($request->kepala_instansi) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['kepala_instansi' => 'Kepala instansi dapat dipilih setelah instansi dibuat.']);
        }
        $existing = Institution::where('nama', $request->nama)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nama' => 'Nama instansi sudah ada.']);
        }
        Institution::create($validated);

        return redirect(routeForRole('institution', 'index'))->with('success', 'Instansi berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Institution $institution)
    {
        return view('institution.show', compact('institution'));
    }

    public function edit(Institution $institution)
{
    // employees directly tied to this institution
    $employees = $institution->employees;

    return view('institution.edit_institution', compact('institution','employees'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Institution $institution)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'pemerintah' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'kepala_instansi_id' => 'nullable|exists:employees,id',

        ], [
            'nama.required' => 'Nama instansi wajib diisi.',
            'pemerintah.required' => 'Nama pemerintah wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'kepala_instansi_id.exists' => 'Kepala instansi tidak ditemukan.',

        ]);
        // Validasi tambahan: pastikan kepala_instansi adalah anggota instansi ini
        // perlu di verif apakah ini bekerja
        if ($request->kepala_instansi_id) {
            $employee = Employee::find($request->kepala_instansi_id);
            // dd($employee->department?);
            if ($employee && $employee->institution?->id != $institution->id) {
            // if ($employee && $employee->department?->instansi_id != $institution->id) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['kepala_instansi_id' => 'Kepala instansi harus merupakan anggota instansi ini.']);
            }
        }
        $existing = Institution::where('nama', $request->nama)
            ->where('id', '!=', $institution->id) // Kecualikan record yang sedang diupdate
            ->first();
        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nama' => 'Nama institusi sudah ada.']);
        }

        $original = $institution->replicate();
        $institution->fill($validated);
        if (!$institution->isDirty()) {
            return back()->with('info', 'Tidak ada perubahan pada data instansi.');
        }

        $institution->save();
        $institution->update($validated);

        return redirect(routeForRole('institution', 'index'))->with('success', 'Instansi berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Institution $institution)
    {
        try {
            $institution->delete();
            return redirect(routeForRole('institution', 'index'))->with('success', 'Instansi berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect(routeForRole('institution', 'index'))->with('error', 'Gagal menghapus instansi. Instansi masih digunakan dalam data lain.');
        }
    }
}
