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
        $categories = Category::with('categoryGroup')->latest()->paginate(15);
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

        $validated = $request->validate([
            'nama' => 'required|string|max:255|unique:categories,nama',
            'deskripsi' => 'nullable|string',
            'category_group_id' => 'required|exists:category_groups,id',
            'alias' => 'required|string|max:255|unique:categories,alias',
        ]);

       Category::create($validated);

    session()->flash('success', 'Kategori berhasil ditambahkan!');

    return response()->json(['success' => true]);
         
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
        try {
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
            return back()->with('info', 'Tidak ada perubahan pada data aset.');
        }
        $category->save();



        // $category->update($validated);

        session()->flash('success', 'Kategori berhasil di ubah');

    return response()->json(['success' => true]);}   
    catch (\Illuminate\Validation\ValidationException $e) {
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
