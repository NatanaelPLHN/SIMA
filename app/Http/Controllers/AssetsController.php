<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AsetBergerak;
use App\Models\AsetTidakBergerak;
use App\Models\AsetHabisPakai;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    public function index()
    {
        $assets = Asset::with(['bergerak', 'tidakBergerak', 'habisPakai'])->paginate(10);
        return view('assets.index', compact('assets'));
    }

    public function create()
    {
        return view('assets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:aset,kode',
            'nama_aset' => 'required',
            'jenis_aset' => 'required|in:bergerak,tidak_bergerak,habis_pakai',
            'kategori' => 'nullable|string',
            'group_kategori' => 'nullable|string',
            'jumlah' => 'required|integer|min:1',
            'tgl_pembelian' => 'nullable|date',
            'nilai_pembelian' => 'nullable|numeric',
            'lokasi_terakhir' => 'nullable|string',
            'status' => 'required|in:tersedia,dipakai,rusak,hilang,habis',
        ]);

        $asset = Asset::create($validated);

        // handle detail table
        if ($validated['jenis_aset'] === 'bergerak') {
            AsetBergerak::create([
                'aset_id' => $asset->id,
                'merk' => $request->merk,
                'tipe' => $request->tipe,
                'tahun_produksi' => $request->tahun_produksi,
            ]);
        }

        if ($validated['jenis_aset'] === 'tidak_bergerak') {
            AsetTidakBergerak::create([
                'aset_id' => $asset->id,
                'ukuran' => $request->ukuran,
                'bahan' => $request->bahan,
            ]);
        }

        if ($validated['jenis_aset'] === 'habis_pakai') {
            AsetHabisPakai::create([
                'aset_id' => $asset->id,
                'register' => $request->register,
                'satuan' => $request->satuan,
            ]);
        }

        return redirect()->route('assets.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    public function show(Asset $asset)
    {
        $asset->load(['bergerak', 'tidakBergerak', 'habisPakai']);
        return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $asset->load(['bergerak', 'tidakBergerak', 'habisPakai']);
        return view('assets.edit', compact('asset'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'nama_aset' => 'required',
            'kategori' => 'nullable|string',
            'group_kategori' => 'nullable|string',
            'jumlah' => 'required|integer|min:1',
            'tgl_pembelian' => 'nullable|date',
            'nilai_pembelian' => 'nullable|numeric',
            'lokasi_terakhir' => 'nullable|string',
            'status' => 'required|in:tersedia,dipakai,rusak,hilang,habis',
        ]);

        $asset->update($validated);

        if ($asset->jenis_aset === 'bergerak') {
            $asset->bergerak()->update([
                'merk' => $request->merk,
                'tipe' => $request->tipe,
                'tahun_produksi' => $request->tahun_produksi,
            ]);
        }

        if ($asset->jenis_aset === 'tidak_bergerak') {
            $asset->tidakBergerak()->update([
                'ukuran' => $request->ukuran,
                'bahan' => $request->bahan,
            ]);
        }

        if ($asset->jenis_aset === 'habis_pakai') {
            $asset->habisPakai()->update([
                'register' => $request->register,
                'satuan' => $request->satuan,
            ]);
        }

        return redirect()->route('assets.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Aset berhasil dihapus.');
    }
}
