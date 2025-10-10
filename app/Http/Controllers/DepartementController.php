<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Institution;
use App\Models\Employee;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class DepartementController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Departement::class, 'departement');
    }

    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $departements = Departement::with(['institution', 'kepala'])->paginate(10);
    //     return view('departement.index', compact('departements'));
    // }
    public function index()
    {
        $user = Auth::user();
        $institutionId = $user->employee?->institution->id;

        // Jika admin tidak terhubung ke institusi, jangan tampilkan apa-apa.
        if (!$institutionId) {
            $departements = collect(); // Membuat koleksi kosong
        } else {
            // Ambil hanya departemen yang instansi_id-nya cocok.
            $departements = Departement::where('instansi_id', $institutionId)
                ->with(['institution', 'kepala'])
                ->paginate(10);
        }

        return view('departement.index', compact('departements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     $institutions = Institution::all();
    //     $employees = collect();
    //     return view('departement.create_departement', compact('institutions', 'employees'));
    // }
    public function create()
    {
        $employees = collect();

        return view('departement.create_departement', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kepala_bidang_id' => 'nullable|exists:employees,id',
            'lokasi' => 'nullable|string|max:255',
            // 'instansi_id' => 'required|exists:institutions,id',
            'alias' => 'required|string|max:255|unique:departements,alias',
        ], [
            'nama.required' => 'Nama bidang wajib diisi.',
            'alias.required' => 'Alias bidang wajib diisi.',
            // 'instansi_id.required' => 'Instansi wajib dipilih.',
            // 'instansi_id.exists' => 'Instansi tidak ditemukan.',
            'alias.unique' => 'Alias ini sudah digunakan.',
            'kepala_bidang_id.exists' => 'Kepala bidang tidak ditemukan.',
        ]);
        // 2. Ambil ID institusi dari user yang sedang login
        $institutionId = Auth::user()->employee?->institution->id;

        if (!$institutionId) {
            return redirect()->back()->with('error', 'Akun Anda tidak terhubung dengan institusi manapun.');
        }
        // Validasi: kepala_bidang harus null saat create karena bidang belum ada
        if ($request->kepala_bidang) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['kepala_bidang' => 'Kepala bidang dapat dipilih setelah bidang dibuat.']);
        }
        // Validasi custom: nama dan instansi harus unique bersama
        $existing = Departement::where('nama', $request->nama)
            ->where('instansi_id', $institutionId)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nama' => 'Nama bidang sudah ada untuk instansi ini.']);
        }
        $validated['instansi_id'] = $institutionId;
        $departement = Departement::create($validated);

        return redirect(routeForRole('departement', 'index'))->with('success', 'Bidang berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Departement $departement)
    {
        $departement->load(['institution', 'kepala', 'employees']);
        return view('departement.show', compact('departement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departement $departement)
    {
        $institutions = Institution::all();
        // Hanya tampilkan employee yang ada di departement ini
        $employees = Employee::where('department_id', $departement->id)->get();
        return view('departement.edit_departement', compact('departement', 'institutions', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departement $departement)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kepala_bidang_id' => 'nullable|exists:employees,id',
            'lokasi' => 'nullable|string|max:255',
            'instansi_id' => 'required|exists:institutions,id',
            // 'Alias' => 'required|string|max:255',
        ], [
            'nama.required' => 'Nama bidang wajib diisi.',
            'instansi_id.required' => 'Instansi wajib dipilih.',
            'instansi_id.exists' => 'Instansi tidak ditemukan.',
            'kepala_bidang_id.exists' => 'Kepala bidang tidak ditemukan.',
        ]);

        // Validasi tambahan: pastikan kepala_bidang adalah anggota departement ini
        if ($request->kepala_bidang_id) {
            $employee = Employee::find($request->kepala_bidang_id);
            if ($employee && $employee->department_id != $departement->id) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['kepala_bidang_id' => 'Kepala bidang harus merupakan anggota departement ini.']);
            }
        }
        // Validasi custom: nama dan instansi harus unique bersama
        $existing = Departement::where('nama', $request->nama)
            ->where('instansi_id', $request->instansi_id)
            ->where('id', '!=', $departement->id) // Kecualikan record yang sedang diupdate
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['nama' => 'Nama departement sudah ada untuk instansi ini.']);
        }
        $original = $departement->replicate();
        $departement->fill($validated);
        if (!$departement->isDirty()) {
            return back()->with('info', 'Tidak ada perubahan pada data departement.');
        }
        $departement->save();
        $departement->update($validated);

        return redirect(routeForRole('departement', 'index'))->with('success', 'Bidang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departement $departement)
    {
        try {
            $departement->delete();
            return redirect(routeForRole('departement', 'index'))->with('success', 'Bidang berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect(routeForRole('departement', 'index'))->with('error', 'Gagal menghapus departement. Departement masih digunakan dalam data lain.');
        }
    }
}
