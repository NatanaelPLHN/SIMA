<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Asset;
use App\Models\Departement;
class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowing = Borrowing::with(['asset', 'employee', 'employee.department'])->paginate(10);

        return view('borrowing.index', compact('borrowing'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::where('status', 'tersedia')->get(); // Hanya tampilkan asset yang tersedia
        $employees = Employee::all();
        $departements = Departement::all();

        return view('borrowing.create_borrowing', compact('assets', 'employees', 'departements'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:aset,id',
            'borrowed_by' => 'required|exists:employees,id',
            // 'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date|before_or_equal:today',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            // 'status' => 'required|in:dipinjam,dikembalikan,terlambat',
            'tujuan_penggunaan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'asset_id.exists' => 'Asset tidak ditemukan.',
            'borrowed_by.exists' => 'Karyawan tidak ditemukan.',
            // 'jumlah.min' => 'Jumlah minimal 1.',
            'tanggal_pinjam.before_or_equal' => 'Tanggal pinjam tidak boleh melebihi hari ini.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali harus setelah tanggal pinjam.',
            'status.in' => 'Status tidak valid.',
        ]);

        // Validasi tambahan: cek jumlah tidak melebihi jumlah asset
        $asset = Asset::find($request->asset_id);
        // if ($request->jumlah > $asset->jumlah) {
        //     return redirect()->back()
        //         ->withInput()
        //         ->withErrors(['jumlah' => 'Jumlah pinjam melebihi jumlah asset yang tersedia.']);
        // }

        // Update status asset
        if ($request->status === 'dipinjam') {
            $asset->update(['status' => 'dipakai']);
        }

        Borrowing::create($validated);

        return redirect()->route('admin.borrowing.index')->with('success', 'Peminjaman berhasil ditambahkan.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        $borrowing->load(['asset', 'employee', 'employee.department']);
        return view('borrowing.show', compact('borrowing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        $borrowing->load(['asset', 'employee', 'employee.department']);
        $assets = Asset::all();
        $employees = Employee::all();
        $departements = Departement::all();

        return view('borrowing.edit_borrowing', compact('borrowing', 'assets', 'employees', 'departements'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:aset,id',
            'borrowed_by' => 'required|exists:employees,id',
            // 'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:dipinjam,dikembalikan,terlambat',
            'tujuan_penggunaan' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'asset_id.exists' => 'Asset tidak ditemukan.',
            'borrowed_by.exists' => 'Karyawan tidak ditemukan.',
            // 'jumlah.min' => 'Jumlah minimal 1.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali harus setelah tanggal pinjam.',
            'status.in' => 'Status tidak valid.',
        ]);

        // Validasi tambahan: cek jumlah tidak melebihi jumlah asset
        $asset = Asset::find($request->asset_id);
        // if ($request->jumlah > $asset->jumlah) {
        //     return redirect()->back()
        //         ->withInput()
        //         ->withErrors(['jumlah' => 'Jumlah pinjam melebihi jumlah asset yang tersedia.']);
        // }

        // Update status asset berdasarkan status peminjaman
        if ($request->status === 'dikembalikan' && $borrowing->status !== 'dikembalikan') {
            $asset->update(['status' => 'tersedia']);
        } elseif ($request->status === 'dipinjam' && $borrowing->status !== 'dipinjam') {
            $asset->update(['status' => 'dipakai']);
        }

        $borrowing->update($validated);

        return redirect()->route('admin.borrowing.index')->with('success', 'Peminjaman berhasil diperbarui.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        try {
            $borrowing->delete();
            return redirect()->route('admin.borrowing.index')->with('success', 'Data peminjaman berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.borrowing.index')->with('error', 'Gagal menghapus data peminjaman.');
        }
    }
}
