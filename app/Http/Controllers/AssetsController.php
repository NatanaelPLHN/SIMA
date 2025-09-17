<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AsetBergerak;
use App\Models\AsetTidakBergerak;
use App\Models\AsetHabisPakai;
use Illuminate\Http\Request;

class AssetsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Asset::class, 'asset');
    }
    public function index()
    {
        $assetsBergerak = Asset::where('jenis_aset', 'bergerak')->with('bergerak')->paginate(10, ['*'], 'bergerak_page');
        $assetsTidakBergerak = Asset::where('jenis_aset', 'tidak_bergerak')->with('tidakBergerak')->paginate(10, ['*'], 'tidak_bergerak_page');
        $assetsHabisPakai = Asset::where('jenis_aset', 'habis_pakai')->with('habisPakai')->paginate(10, ['*'], 'habis_pakai_page');

        return view('admin.asset', compact('assetsBergerak', 'assetsTidakBergerak', 'assetsHabisPakai'));
    }

    public function create_gerak()
    {
        return view('admin.Forms.create_gerak');
    }
    public function create_tidak()
    {
        return view('admin.Forms.create_tidak_bergerak');
    }
    public function create_habis()
    {
        return view('admin.Forms.create_habis');
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
                'nomor_serial' => $request->nomor_serial,
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

        return redirect()->route('admin.assets.index')->with('success', 'Aset berhasil ditambahkan.');

    }

    public function show(Asset $asset)
    {
        $asset->load(['bergerak', 'tidakBergerak', 'habisPakai']);
        // return view('assets.show', compact('asset'));
    }

    public function edit(Asset $asset)
    {
        $asset->load(['bergerak', 'tidakBergerak', 'habisPakai']);

        if ($asset->jenis_aset === 'bergerak') {
            return view('admin.Forms.edit_gerak', compact('asset'));
        }

        if ($asset->jenis_aset === 'tidak_bergerak') {
            return view('admin.Forms.edit_tidak_bergerak', compact('asset'));
        }

        if ($asset->jenis_aset === 'habis_pakai') {
            return view('admin.Forms.edit_habis', compact('asset'));
        }

        abort(404);
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
                'nomor_serial' => $request->nomor_serial,
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

        return redirect()->route('admin.assets.index')->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('admin.assets.index')->with('success', 'Aset berhasil dihapus.');
    }

}


