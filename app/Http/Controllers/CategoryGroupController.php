<?php

namespace App\Http\Controllers;

use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        DB::beginTransaction();
        try {
            $categoryGroup = CategoryGroup::create($validated);
            DB::commit();

            session()->flash('success', 'Grup Kategori berhasil ditambahkan!');

            if ($request->ajax()) {
                return response()->json(['success' => true, 'category_group' => $categoryGroup], 201);
            }

            return redirect()->route('superadmin.category-groups.index')->with('success', 'Grup Kategori berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating category group: ' . $e->getMessage(), ['exception' => $e, 'payload' => $validated]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan data group kategori. Silakan coba lagi.'
                ], 500);
            }

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
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:category_groups,nama,' . $categoryGroup->id,
                'deskripsi' => 'nullable|string',
                'alias' => 'required|string|max:255|unique:category_groups,alias,' . $categoryGroup->id,
            ], [
                'nama.required' => 'Nama group kategori wajib diisi.',
                'nama.unique' => 'Nama group kategori sudah digunakan.',
                'alias.required' => 'Alias wajib diisi.',
                'alias.unique' => 'Alias sudah digunakan.',
            ]);
        } catch (ValidationException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal.',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        DB::beginTransaction();
        try {
            $categoryGroup->fill($validated);
            if (!$categoryGroup->isDirty()) {
                DB::rollBack();
                if ($request->ajax()) {
                    return response()->json(['success' => true, 'info' => 'Tidak ada perubahan pada data grup kategori.']);
                }
                return back()->with('info', 'Tidak ada perubahan pada data aset.');
            }

            $categoryGroup->save();
            DB::commit();

            session()->flash('success', 'Grup Kategori berhasil di ubah');

            if ($request->ajax()) {
                return response()->json(['success' => true, 'category_group' => $categoryGroup]);
            }

            return redirect()->route('superadmin.category-groups.index')->with('success', 'Grup Kategori berhasil di ubah');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating category group: ' . $e->getMessage(), ['exception' => $e, 'category_group_id' => $categoryGroup->id, 'payload' => $validated]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat memperbarui data.'
                ], 500);
            }

            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui data group kategori.');
        }
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

            DB::beginTransaction();
            try {
                $categoryGroup->delete();
                DB::commit();

                return redirect()->route('superadmin.category-groups.index')->with('success', 'Group kategori berhasil dihapus.');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Error deleting category group: ' . $e->getMessage(), ['exception' => $e, 'category_group_id' => $categoryGroup->id]);
            return redirect()->route('superadmin.category-groups.index')->with('error', 'Gagal menghapus group kategori.');
        }
    }
}
