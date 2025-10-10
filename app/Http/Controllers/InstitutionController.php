<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InstitutionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Institution::class, 'institution');
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');

        $allowedSorts = ['nama', 'alamat', 'telepon', 'email', 'kepala'];
        if (!in_array($sort, $allowedSorts)) $sort = 'nama';
        if (!in_array(strtolower($direction), ['asc', 'desc'])) $direction = 'asc';

        $query = Institution::with('kepala');

        // Filter pencarian
        $query->when($search, function ($q) use ($search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('nama', 'like', "%{$search}%")
                    ->orWhere('alamat', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('kepala', fn($k) => $k->where('nama', 'like', "%{$search}%"));
            });
        });

        // Sorting
        if ($sort === 'kepala') {
            $query->join('employees', 'institutions.kepala_instansi_id', '=', 'employees.id')
                ->orderBy('employees.nama', $direction)
                ->select('institutions.*')
                ->distinct();
        } else {
            $query->orderBy($sort, $direction);
        }

        $institutions = $query->paginate(10)->appends([
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
        ]);

        return view('institution.index', compact('institutions'));
    }

    public function create()
    {
        $employees = collect();
        return view('institution.create_institution', compact('employees'));
    }

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
            return back()->withInput()
                ->withErrors(['kepala_instansi' => 'Kepala instansi dapat dipilih setelah instansi dibuat.']);
        }

        // Prevent duplicate names
        if (Institution::where('nama', $validated['nama'])->exists()) {
            return back()->withInput()->withErrors(['nama' => 'Nama instansi sudah ada.']);
        }

        try {
            DB::transaction(function () use ($validated) {
                Institution::create($validated);
            });

            return redirect(routeForRole('institution', 'index'))
                ->with('success', 'Instansi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan instansi: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Institution $institution)
    {
        return view('institution.show', compact('institution'));
    }

    public function edit(Institution $institution)
    {
        $employees = $institution->employees;
        return view('institution.edit_institution', compact('institution', 'employees'));
    }

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

        // Validasi: kepala instansi harus dari instansi yang sama
        if ($request->kepala_instansi_id) {
            $employee = Employee::find($request->kepala_instansi_id);
            if ($employee && $employee->institution?->id != $institution->id) {
                return back()->withInput()
                    ->withErrors(['kepala_instansi_id' => 'Kepala instansi harus merupakan anggota instansi ini.']);
            }
        }

        // Cek duplikasi nama
        if (Institution::where('nama', $validated['nama'])->where('id', '!=', $institution->id)->exists()) {
            return back()->withInput()->withErrors(['nama' => 'Nama institusi sudah ada.']);
        }

        try {
            DB::transaction(function () use ($institution, $validated) {
                $institution->fill($validated);

                if ($institution->isDirty()) {
                    $institution->save();
                }
            });

            return redirect(routeForRole('institution', 'index'))
                ->with('success', 'Instansi berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memperbarui instansi: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Institution $institution)
    {
        // KEKNYA BISA DI ATUR DI MIGRATION RELASI NYA
        // Cek apakah ada employee yang masih terhubung dengan instansi ini.
        if ($institution->employees()->exists()) {
            return redirect(routeForRole('institution', 'index'))
                ->with('error', 'Gagal menghapus: Masih ada karyawan yang terdaftar di instansi ini.');
        }
        try {
            DB::transaction(function () use ($institution) {
                $institution->delete();
            });

            return redirect(routeForRole('institution', 'index'))
                ->with('success', 'Instansi berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect(routeForRole('institution', 'index'))
                ->with('error', 'Gagal menghapus instansi. Instansi masih digunakan dalam data lain.');
        }
    }
}
