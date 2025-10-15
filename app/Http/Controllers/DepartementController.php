<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Institution;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class DepartementController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Departement::class, 'departement');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $institutionId = $user->employee?->institution?->id;

        // Jika admin tidak terhubung ke institusi, jangan tampilkan apa-apa.
        if (!$institutionId) {
            $departements = collect(); // Koleksi kosong
            return view('departement.index', compact('departements'));
        }

        // Ambil parameter query
        $search = $request->get('search');
        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');

        // Validasi kolom sorting yang diizinkan
        $allowedSorts = ['nama', 'alias', 'created_at']; // Sesuaikan dengan kolom di tabel departements
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'nama';
        }
        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'asc';
        }

        // Mulai query
        $query = Departement::where('instansi_id', $institutionId)
            ->with(['institution', 'kepala']);

        // === Pencarian ===
        $query->when($search, function ($q) use ($search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('nama', 'like', "%{$search}%")
                    ->orWhere('alias', 'like', "%{$search}%")
                    ->orWhere('lokasi', 'like', "%{$search}%")
                    ->orWhereHas('kepala', fn($k) => $k->where('nama', 'like', "%{$search}%"));
                    // ->orWhereHas('institution', fn($i) => $i->where('nama', 'like', "%{$search}%"));
            });
        });

        // === Sorting ===
        // Jika sort berdasarkan relasi, lakukan join
        if ($sort === 'kepala') {
            $query->join('employees', 'departements.kepala_id', '=', 'employees.id')
                ->orderBy('employees.nama', $direction)
                ->select('departements.*')
                ->distinct();
        } elseif ($sort === 'institution') {
            $query->join('institutions', 'departements.instansi_id', '=', 'institutions.id')
                ->orderBy('institutions.nama', $direction)
                ->select('departements.*')
                ->distinct();
        } else {
            $query->orderBy($sort, $direction);
        }

        // Pagination dengan append query string
        $departements = $query->paginate(10)->appends([
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
        ]);

        return view('departement.index', compact('departements'));
    }

    public function create()
    {
        // Keep employees empty for create (you can load via AJAX if needed)
        $employees = collect();

        return view('departement.create_departement', compact('employees'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kepala_bidang_id' => 'nullable|exists:employees,id',
                'lokasi' => 'nullable|string|max:255',
                'alias' => 'required|string|max:255|unique:departements,alias',
            ], [
                'nama.required' => 'Nama bidang wajib diisi.',
                'alias.required' => 'Alias bidang wajib diisi.',
                'alias.unique' => 'Alias ini sudah digunakan.',
                'kepala_bidang_id.exists' => 'Kepala bidang tidak ditemukan.',
            ]);
        } catch (ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors(),
                ], 422);
            }
            throw $e;
        }

        // 2. Ambil ID institusi dari user yang sedang login
        $institutionId = Auth::user()->employee?->institution?->id;

        if (!$institutionId) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Akun Anda tidak terhubung dengan institusi manapun.'], 403);
            }
            return redirect()->back()->with('error', 'Akun Anda tidak terhubung dengan institusi manapun.');
        }

        // Validasi: kepala_bidang harus null saat create karena bidang belum ada
        if ($request->filled('kepala_bidang_id')) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['kepala_bidang_id' => ['Kepala bidang dapat dipilih setelah bidang dibuat.']]
                ], 422);
            }
            return redirect()->back()
                ->withInput()
                ->withErrors(['kepala_bidang_id' => 'Kepala bidang dapat dipilih setelah bidang dibuat.']);
        }

        // Validasi custom: nama dan instansi harus unique bersama
        $existing = Departement::where('nama', $request->nama)
            ->where('instansi_id', $institutionId)
            ->first();

        if ($existing) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['nama' => ['Nama bidang sudah ada untuk instansi ini.']]
                ], 422);
            }
            return redirect()->back()
                ->withInput()
                ->withErrors(['nama' => 'Nama bidang sudah ada untuk instansi ini.']);
        }

        $validated['instansi_id'] = $institutionId;

        DB::beginTransaction();
        try {
            $departement = Departement::create($validated);
            DB::commit();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'departement' => $departement], 201);
            }

            return redirect(routeForRole('departement', 'index'))->with('success', 'Bidang berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create departement: ' . $e->getMessage(), ['exception' => $e, 'payload' => $validated]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal menambahkan bidang. Silakan coba lagi.'], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan bidang.');
        }
    }

    public function show(Departement $departement)
    {
        $departement->load(['institution', 'kepala', 'employees']);
        return view('departement.show', compact('departement'));
    }

    public function edit(Departement $departement)
    {
        $institutions = Institution::all();
        // Hanya tampilkan employee yang ada di departement ini
        $employees = Employee::where('department_id', $departement->id)->get();
        return view('departement.edit_departement', compact('departement', 'institutions', 'employees'));
    }

    public function update(Request $request, Departement $departement)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kepala_bidang_id' => 'nullable|exists:employees,id',
                'lokasi' => 'nullable|string|max:255',
                'instansi_id' => 'required|exists:institutions,id',
                // 'alias' => 'nullable|string|max:255', // alias update handled elsewhere if required
            ], [
                'nama.required' => 'Nama bidang wajib diisi.',
                'instansi_id.required' => 'Instansi wajib dipilih.',
                'instansi_id.exists' => 'Instansi tidak ditemukan.',
                'kepala_bidang_id.exists' => 'Kepala bidang tidak ditemukan.',
            ]);
        } catch (ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'errors' => $e->errors()], 422);
            }
            throw $e;
        }

        // Validasi tambahan: pastikan kepala_bidang adalah anggota departement ini
        if ($request->filled('kepala_bidang_id')) {
            $employee = Employee::find($request->kepala_bidang_id);
            if ($employee && $employee->department_id != $departement->id) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'errors' => ['kepala_bidang_id' => ['Kepala bidang harus merupakan anggota departement ini.']]
                    ], 422);
                }
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['kepala_bidang_id' => 'Kepala bidang harus merupakan anggota departement ini.']);
            }
        }

        // Validasi custom: nama dan instansi harus unique bersama (kecualikan record sekarang)
        $existing = Departement::where('nama', $request->nama)
            ->where('instansi_id', $request->instansi_id)
            ->where('id', '!=', $departement->id)
            ->first();

        if ($existing) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['nama' => ['Nama departement sudah ada untuk instansi ini.']]
                ], 422);
            }
            return redirect()->back()
                ->withInput()
                ->withErrors(['nama' => 'Nama departement sudah ada untuk instansi ini.']);
        }

        DB::beginTransaction();
        try {
            $original = $departement->replicate();
            $departement->fill($validated);

            if (!$departement->isDirty()) {
                DB::rollBack();
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json(['success' => true, 'info' => 'Tidak ada perubahan pada data departement.']);
                }
                return back()->with('info', 'Tidak ada perubahan pada data departement.');
            }

            $departement->save();
            DB::commit();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'departement' => $departement]);
            }

            return redirect(routeForRole('departement', 'index'))->with('success', 'Bidang berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update departement: ' . $e->getMessage(), ['exception' => $e, 'department_id' => $departement->id, 'payload' => $validated]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui bidang.'], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui bidang.');
        }
    }

    public function destroy(Departement $departement)
    {
        // KEKNYA BISA DI ATUR DI MIGRATION RELASI NYA
        // Cek apakah ada employee yang masih terhubung dengan instansi ini.
        if ($departement->employees()->exists()) {
            return redirect(routeForRole('departement', 'index'))
                ->with('error', 'Gagal menghapus: Masih ada karyawan yang terdaftar di departement ini.');
        }

        try {
            // Prevent deletion if there are employees or other related data
            if ($departement->employees()->count() > 0) {
                return redirect(routeForRole('departement', 'index'))->with('error', 'Tidak dapat menghapus departement yang masih memiliki pegawai.');
            }

            DB::beginTransaction();
            try {
                $departement->delete();
                DB::commit();
                return redirect(routeForRole('departement', 'index'))->with('success', 'Bidang berhasil dihapus.');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete departement: ' . $e->getMessage(), ['exception' => $e, 'department_id' => $departement->id]);
            return redirect(routeForRole('departement', 'index'))->with('error', 'Gagal menghapus departement. Departement masih digunakan dalam data lain.');
        }
    }
}
