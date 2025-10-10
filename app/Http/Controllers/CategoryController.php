<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        return view('categories.create', compact( 'groupCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
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

       Category::create($validated);

    session()->flash('success', 'Kategori berhasil ditambahkan!');

    return response()->json(['success' => true]);
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
    } /**
     * Display the   specified resource.
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
        $categoryGroups = CategoryGroup::all();
        return view('categories.edit', compact('category', 'groupCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama,' . $category->id,
            'deskripsi' => 'nullable|string',
            'category_group_id' => 'required|exists:category_groups,id',
            'alias' => 'required|string|max:255|unique:categories,alias,' . $category->id,
        ], [
            'nama.required' => 'Nama kategori wajib diisi.',
            'nama.unique' => 'Nama kategori sudah digunakan.',
            'category_group_id.required' => 'Group kategori wajib dipilih.',
            'alias.required' => 'Alias wajib diisi.',
            'alias.unique' => 'Alias sudah digunakan.',
        ]);
        $category->fill($validated);
        
        if (!$category->isDirty()) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada perubahan pada data.',
            ]);
        }
        return back()->with('info', 'Tidak ada perubahan pada data.');
    }

    $category->save();

    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diubah.'
        ]);
    }
    return back()->with('success', 'Kategori berhasil diubah.');
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
            $category->delete();
            return redirect()->route('superadmin.categories.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
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
