<?php

namespace App\Http\Controllers;

use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil parameter dari request
        $search = $request->get('search');
        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');

        // Validasi kolom sorting yang diizinkan
        $allowedSorts = ['nama', 'created_at'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'nama';
        }
        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'asc';
        }

        // Mulai query dengan relasi (jika diperlukan, misalnya untuk menghitung kategori)
        $query = CategoryGroup::withCount('categories');

        // === Pencarian ===
        $query->when($search, function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
            ->orWhere('deskripsi', 'like', "%{$search}%")
            ->orWhere('alias', 'like', "%{$search}%");
        });

        // === Sorting ===
        $query->orderBy($sort, $direction);

        // Pagination dengan append query string agar tetap ada di halaman berikutnya
        $categoryGroups = $query->paginate(10)->appends([
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
        ]);

        return view('category_groups.category_groups', compact('categoryGroups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('category_groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validasi untuk semua jenis request
            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:category_groups,nama',
                'deskripsi' => 'nullable|string',
                'alias' => 'required|string|max:255|unique:category_groups,alias',
            ], [
                'nama.required' => 'Nama group kategori wajib diisi.',
                'nama.unique' => 'Nama group kategori sudah digunakan.',
                'alias.required' => 'Alias wajib diisi.',
                'alias.unique' => 'Alias sudah digunakan.',
            ]);

            $categoryGroup = CategoryGroup::create($validated);

            // Handle AJAX request (dari SweetAlert2)
             session()->flash('success', ' grup Kategori berhasil ditambahkan!');

            return response()->json(['success' => true]);
    

            // Handle regular form submission
            } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation error untuk AJAX
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $e->errors()
                ], 422);
            }

            throw $e; // Biarkan Laravel menangani validation error untuk form biasa

        } catch (\Exception $e) {
            Log::error('Error creating category group: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            // Handle AJAX error
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan data group kategori. Silakan coba lagi.'
                ], 500);
            }

            // Handle regular form error
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data group kategori.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryGroup $categoryGroup)
    {
        $categoryGroup->load('categories');
        // return view('category_groups.show', compact('categoryGroup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryGroup $categoryGroup)
    {
        // return view('category_groups.edit', compact('categoryGroup'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, CategoryGroup $categoryGroup)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255|unique:category_groups,nama,' . $categoryGroup->id,
        'deskripsi' => 'nullable|string',
        'alias' => 'required|string|max:255|unique:category_groups,alias,' . $categoryGroup->id,
    ], [
        'nama.required' => 'Nama grup kategori wajib diisi.',
        'nama.unique' => 'Nama grup kategori sudah digunakan.',
        'alias.required' => 'Alias wajib diisi.',
        'alias.unique' => 'Alias sudah digunakan.',
    ]);

    $categoryGroup->fill($validated);

    if (!$categoryGroup->isDirty()) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada perubahan pada data.',
                'no_changes' => true
            ]);
        }
        return back()->with('info', 'Tidak ada perubahan pada data.');
    }

    $categoryGroup->save();

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Grup Kategori berhasil diubah.'
        ]);
    }

    return back()->with('success', 'Grup Kategori berhasil diubah.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryGroup $categoryGroup)
    {
        try {
            // Cek apakah masih ada kategori yang menggunakan group ini
            if ($categoryGroup->categories()->count() > 0) {
                return redirect()->route('superadmin.category-groups.index')->with('error', 'Tidak dapat menghapus group kategori karena masih digunakan oleh kategori.');
            }

            $categoryGroup->delete();
            return redirect()->route('superadmin.category-groups.index')->with('success', 'Group kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.category-groups.index')->with('error', 'Gagal menghapus group kategori.');
        }
    }
}
