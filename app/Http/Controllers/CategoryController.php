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
    public function index()
    {
        $categories = Category::with(['parent', 'categoryGroup'])->withCount('children')->latest()->paginate(15);
        $groupCategories = CategoryGroup::all();
        return view('categories.index', compact('categories', 'groupCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        $groupCategories = CategoryGroup::all();
        return view('categories.create', compact('categories', 'groupCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    try {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
            'nama' => 'required|string|max:255|unique:categories,nama',
            'deskripsi' => 'nullable|string',
            'category_group_id' => 'required|exists:category_groups,id',
            'alias' => 'required|string|max:255|unique:categories,alias',
        ]);

        $category = Category::create($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil ditambahkan.',
                'data' => $category
            ]);
        }

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }
        throw $e;
    }
} /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['parent', 'children', 'categoryGroup']);
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();
        $categoryGroups = CategoryGroup::all();
        return view('categories.edit', compact('category', 'categories', 'groupCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
        $validated = $request->validate([
            'parent_id' => 'nullable|exists:categories,id',
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


        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }   catch (\Illuminate\Validation\ValidationException $e) {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
        }
        throw $e;
    }
}
    
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            // Cek apakah kategori memiliki child atau aset
            if ($category->children()->count() > 0) {
                return redirect()->route('superadmin.categories.index')->with('error', 'Tidak dapat menghapus kategori yang memiliki sub-kategori.');
            }

            // if ($category->assets()->count() > 0) {
            //     return redirect()->route('superadmin.categories.index')->with('error', 'Tidak dapat menghapus kategori yang digunakan oleh aset.');
            // }
            $category->delete();
            return redirect()->route('superadmin.categories.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.categories.index')->with('error', 'Gagal menghapus kategori.');
        }
    }
    public function getByGroup(Request $request)
    {
        $groupId = $request->get('group_id');
        $categories = Category::where('category_group_id', $groupId)
                             ->whereNull('parent_id')
                             ->get();

        return response()->json($categories);
    }
}
