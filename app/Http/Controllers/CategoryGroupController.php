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
    public function index()
    {
        $categoryGroups = CategoryGroup::withCount('categories')->latest()->paginate(10);
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
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Group kategori berhasil ditambahkan.',
                    'data' => $categoryGroup
                ]);
            }

            // Handle regular form submission
            return redirect()->route('superadmin.category-groups.index')->with('success', 'Group kategori berhasil ditambahkan.');
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

        $categoryGroup->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Group kategori berhasil diperbarui.',
                'data' => $categoryGroup
            ]);
        }

        return redirect()->route('superadmin.category-groups.index')->with('success', 'Group kategori berhasil diperbarui.');

    } catch (\Illuminate\Validation\ValidationException $e) {
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors' => $e->errors()
            ], 422);
        }
        throw $e;

    } catch (\Exception $e) {
        Log::error('Error updating category group: ' . $e->getMessage());

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

            $categoryGroup->delete();
            return redirect()->route('superadmin.category-groups.index')->with('success', 'Group kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('superadmin.category-groups.index')->with('error', 'Gagal menghapus group kategori.');
        }
    }
}
