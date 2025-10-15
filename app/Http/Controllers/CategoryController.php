<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // <-- added
use Illuminate\Validation\ValidationException; // <-- added

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Ambil parameter query
        $search = $request->get('search');
        $sort = $request->get('sort', 'nama');
        $direction = $request->get('direction', 'asc');

        // Validasi kolom sorting yang diizinkan
        $allowedSorts = ['nama', 'category_group_id'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'nama';
        }
        if (!in_array(strtolower($direction), ['asc', 'desc'])) {
            $direction = 'asc';
        }

        // Mulai query dengan relasi
        $query = Category::with('categoryGroup');

        // === Pencarian ===
        $query->when($search, function ($q) use ($search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('nama', 'like', "%{$search}%")
                    ->orWhereHas('categoryGroup', fn($cg) => $cg->where('nama', 'like', "%{$search}%"));
            });
        });

        // === Sorting ===
        if ($sort === 'category_group_id') {
            $query->join('category_groups', 'categories.category_group_id', '=', 'category_groups.id')
                  ->orderBy('category_groups.nama', $direction)
                  ->select('categories.*')
                  ->distinct();
        } else {
            $query->orderBy($sort, $direction);
        }

        // Pagination dengan append query string
        $categories = $query->paginate(10)->appends([
            'search' => $search,
            'sort' => $sort,
            'direction' => $direction,
        ]);

        // Ambil semua grup kategori untuk dropdown/filter (jika diperlukan di view)
        $groupCategories = CategoryGroup::all();

        return view('categories.index', compact('categories', 'groupCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $categories = Category::all(); // atau kosong dulu kalau mau AJAX
        $groupCategories = CategoryGroup::all();
        return view('categories.create', compact('groupCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama',
            'deskripsi' => 'nullable|string',
            'category_group_id' => 'required|exists:category_groups,id',
            'alias' => 'required|string|max:255|unique:categories,alias',
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori sudah digunakan.',
            'category_group_id.required' => 'Group kategori wajib dipilih.',
            'alias.required' => 'Alias wajib diisi.',
            'alias.unique' => 'Alias sudah digunakan.',
        ]);

        DB::beginTransaction();
        try {
            $category = Category::create($validated);
            DB::commit();

            // session()->flash('success', 'Kategori berhasil ditambahkan!');

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'category' => $category], 201);
            }

            // fallback for non-AJAX requests
            return redirect()->route('superadmin.categories.index')->with('success', 'Kategori berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store category: ' . $e->getMessage(), ['exception' => $e, 'payload' => $validated]);

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal menambahkan kategori.'], 500);
            }

            return back()->withInput()->with('error', 'Gagal menambahkan kategori.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['categoryGroup']);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // fixed variable name to match other views
        $groupCategories = CategoryGroup::all();
        return view('categories.edit', compact('category', 'groupCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|string|max:255|unique:categories,nama,' . $category->id,
                'deskripsi' => 'nullable|string',
                // 'category_group_id' => 'required|exists:category_groups,id',
                'alias' => 'required|string|max:255|unique:categories,alias,' . $category->id,
            ], [
                'nama.required' => 'Nama kategori wajib diisi.',
                'nama.unique' => 'Nama kategori sudah digunakan.',
                // 'category_group_id.required' => 'Group kategori wajib dipilih.',
                'alias.required' => 'Alias wajib diisi.',
                'alias.unique' => 'Alias sudah digunakan.',
            ]);
        } catch (ValidationException $e) {
            // return validation errors as JSON if AJAX, otherwise rethrow so Laravel handles it (redirect + errors)
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        DB::beginTransaction();
        try {
            $category->fill($validated);

            if (!$category->isDirty()) {
                DB::rollBack();
                if ($request->expectsJson()) {
                    return response()->json(['success' => true, 'info' => 'Tidak ada perubahan pada data kategori.']);
                }
                return back()->with('info', 'Tidak ada perubahan pada data aset.');
            }

            $category->save();
            DB::commit();

            // session()->flash('success', 'Kategori berhasil di ubah');

            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'category' => $category]);
            }

            return redirect()->route('superadmin.categories.index')->with('success', 'Kategori berhasil di ubah');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update category: ' . $e->getMessage(), ['exception' => $e, 'category_id' => $category->id, 'payload' => $validated]);

            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Gagal memperbarui kategori.'], 500);
            }

            return back()->withInput()->with('error', 'Gagal memperbarui kategori.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            // Cek apakah kategori memiliki child atau aset
            if ($category->assets()->count() > 0) {
                return redirect()->route('superadmin.categories.index')->with('error', 'Tidak dapat menghapus kategori yang digunakan oleh aset.');
            }

            DB::beginTransaction();
            try {
                $category->delete();
                DB::commit();

                return redirect()->route('superadmin.categories.index')->with('success', 'Kategori berhasil dihapus.');
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete category: ' . $e->getMessage(), ['exception' => $e, 'category_id' => $category->id]);
            return redirect()->route('superadmin.categories.index')->with('error', 'Gagal menghapus kategori.');
        }
    }

    public function getByGroup(Request $request)
    {
        $groupId = $request->get('group_id');
        $categories = Category::where('category_group_id', $groupId)->get();

        return response()->json($categories);
    }
}
