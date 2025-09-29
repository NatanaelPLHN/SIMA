<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AsetBergerak;
use App\Models\AsetTidakBergerak;
use App\Models\AsetHabisPakai;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class AssetsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Asset::class, 'asset');
    }
    public function index()
    {
        $assetsBergerak = Asset::where('jenis_aset', 'bergerak')->with(['bergerak', 'category.categoryGroup'])->paginate(10, ['*'], 'bergerak_page');
        $assetsTidakBergerak = Asset::where('jenis_aset', 'tidak_bergerak')->with(['tidakBergerak', 'category.categoryGroup'])->paginate(10, ['*'], 'tidak_bergerak_page');
        $assetsHabisPakai = Asset::where('jenis_aset', 'habis_pakai')->with(['habisPakai', 'category.categoryGroup'])->paginate(10, ['*'], 'habis_pakai_page');

        return view('aset.index', compact('assetsBergerak', 'assetsTidakBergerak', 'assetsHabisPakai'));
    }
    public function create_gerak()
    {
        $groupCategories = CategoryGroup::with('categories')->get();
        return view('aset.forms.create_gerak', compact('groupCategories'));
    }
    public function create_tidak()
    {
        $groupCategories = CategoryGroup::with('categories')->get();
        return view('aset.forms.create_tidak_bergerak', compact('groupCategories'));
    }
    public function create_habis()
    {
        $groupCategories = CategoryGroup::with('categories')->get();
        return view('aset.forms.create_habis', compact('groupCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_aset' => 'required',
            'jenis_aset' => 'required|in:bergerak,tidak_bergerak,habis_pakai',
            'category_id' => 'required|exists:categories,id',
            'jumlah' => 'required|integer|min:1',
            'tgl_pembelian' => 'required|date|before_or_equal:today',
            'nilai_pembelian' => 'required|numeric|min:0',
            'lokasi_terakhir' => 'required|string',
            'status' => 'required|in:tersedia,dipakai,rusak,hilang,habis',
            'nomor_serial' => 'nullable|required_if:jenis_aset,bergerak|unique:aset_bergerak,nomor_serial',
        ], [
            'kode.unique' => 'Kode aset sudah digunakan.',
            'kode.required' => 'Kode aset wajib diisi.',
            'nama_aset.required' => 'Nama aset wajib diisi.',
            'jenis_aset.required' => 'Jenis aset wajib dipilih.',
            'jumlah.min' => 'Jumlah minimal 1.',
            'tgl_pembelian.before_or_equal' => 'Tanggal pembelian tidak boleh melebihi tanggal hari ini.',
            'nilai_pembelian.min' => 'Nilai pembelian tidak boleh negatif.',
            'nomor_serial.unique' => 'Nomor serial sudah digunakan.',
        ]);

        $user = auth()->user();

        $institutionAlias = $user->employee?->department?->institution?->alias;
        $departmentAlias = $user->employee?->department?->alias;

        $category = Category::find($request->category_id);
        $categoryGroupAlias  = $category->categoryGroup?->id; // category group alias = ID
        $categoryAlias       = $category->id; // category alias = ID

        $kode = implode('-', [$institutionAlias, $departmentAlias, $categoryGroupAlias, $categoryAlias]);

        do {
            $kode = implode('-', [
                $institutionAlias,
                $departmentAlias,
                $categoryGroupAlias,
                $categoryAlias
            ]);
        } while (Asset::where('kode', $kode)->exists());

        $validated['kode'] = $kode;
        $asset = Asset::create($validated);

        // handle details table
        if ($validated['jenis_aset'] === 'bergerak') {
            $assetBergerak = AsetBergerak::create([
                'aset_id' => $asset->id,
                'merk' => $request->merk,
                'tipe' => $request->tipe,
                'nomor_serial' => $request->nomor_serial,
                'tahun_produksi' => $request->tahun_produksi,
            ]);
            $qrCodePath = 'qrcodes\\' . $asset->kode . '.svg';
            $fullPath = storage_path("app\public\\" . $qrCodePath);

            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }
            // route('superadmin.assets.show', $assetBergerak->id)
            QrCode::format('svg')->size(200)->generate(route('asset.public.verify', $asset->kode), $fullPath);
            $assetBergerak->update(['qr_code_path' => $qrCodePath]);
        }

        if ($validated['jenis_aset'] === 'tidak_bergerak') {
            $assetTidak = AsetTidakBergerak::create([
                'aset_id' => $asset->id,
                'ukuran' => $request->ukuran,
                'bahan' => $request->bahan,
            ]);
            $qrCodePath = 'qrcodes\\' . $asset->kode . '.svg';
            $fullPath = storage_path("app\public\\" . $qrCodePath);

            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            QrCode::format('svg')->size(200)->generate(route('asset.public.verify', $asset->kode), $fullPath);
            $assetTidak->update(['qr_code_path' => $qrCodePath]);
        }

        if ($validated['jenis_aset'] === 'habis_pakai') {
            AsetHabisPakai::create([
                'aset_id' => $asset->id,
                'register' => $request->register,
                'satuan' => $request->satuan,
            ]);
        }
        // $prefix = request()->is('superadmin/*') ? 'superadmin' : 'admin';

        return redirect()->route(match (auth()->user()->role) {
            'superadmin' => 'superadmin.assets.index',
            'admin'      => 'admin.assets.index',
            // 'user'       => 'user.assets.index', //user gak ada
            default      => 'login',
        })->with('success', 'Aset berhasil ditambahkan.');
    }


    public function show(Asset $asset)
    {
        $asset->load(['bergerak', 'tidakBergerak', 'habisPakai', 'category.categoryGroup']);

        if ($asset->jenis_aset === 'bergerak') {
            return view('aset.details.bergerak', compact('asset'));
        }

        if ($asset->jenis_aset === 'tidak_bergerak') {
            return view('aset.details.tidak_bergerak', compact('asset'));
        }

        if ($asset->jenis_aset === 'habis_pakai') {
            return view('aset.details.habis', compact('asset'));
        }

        abort(404);
    }
    public function edit(Asset $asset)
    {
        $asset->load(['bergerak', 'tidakBergerak', 'habisPakai', 'category.categoryGroup']);
        $groupCategories = CategoryGroup::with('categories')->get();

        if ($asset->jenis_aset === 'bergerak') {
            return view('aset.forms.edit_gerak', compact('asset', 'groupCategories'));
        }

        if ($asset->jenis_aset === 'tidak_bergerak') {
            return view('aset.forms.edit_tidak_bergerak', compact('asset', 'groupCategories'));
        }

        if ($asset->jenis_aset === 'habis_pakai') {
            return view('aset.forms.edit_habis', compact('asset', 'groupCategories'));
        }

        abort(404);
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'nama_aset' => 'required',
            'category_id' => 'required|exists:categories,id',
            'jumlah' => 'required|integer|min:1',
            'tgl_pembelian' => 'nullable|date',
            'nilai_pembelian' => 'nullable|numeric',
            'lokasi_terakhir' => 'nullable|string',
            'status' => 'required|in:tersedia,dipakai,rusak,hilang,habis',
        ]);

        $original = $asset->replicate();
        $asset->fill($validated);
        if (!$asset->isDirty()) {
            return back()->with('info', 'Tidak ada perubahan pada data aset.');
        }

        $asset->save();

        if ($asset->jenis_aset === 'bergerak') {
            $asset->bergerak()->update([
                'merk' => $request->merk,
                'tipe' => $request->tipe,
                'nomor_serial' => $request->nomor_serial,
                'tahun_produksi' => $request->tahun_produksi,
            ]);
            if ($asset->bergerak->isDirty()) {
                $asset->bergerak->save();
            }
        }

        if ($asset->jenis_aset === 'tidak_bergerak') {
            $asset->tidakBergerak()->update([
                'ukuran' => $request->ukuran,
                'bahan' => $request->bahan,
            ]);
            if ($asset->tidakBergerak->isDirty()) {
                $asset->tidakBergerak->save();
            }
        }

        if ($asset->jenis_aset === 'habis_pakai') {
            $asset->habisPakai()->update([
                'register' => $request->register,
                'satuan' => $request->satuan,
            ]);
            if ($asset->habisPakai->isDirty()) {
                $asset->habisPakai->save();
            }
        }

        return redirect()->route(match (auth()->user()->role) {
            'superadmin' => 'superadmin.assets.index',
            // 'admin'      => 'admin.assets.index',
            // 'user'       => 'user.assets.index', //user gak ada
            default      => 'login',
        })->with('success', 'Aset berhasil diperbarui.');
    }

    public function destroy(Asset $asset)
    {
        // Tentukan path file QR code berdasarkan kode aset.
        // Pastikan path ini konsisten dengan cara Anda menyimpannya di method store().
        $qrCodePath = 'qrcodes/' . $asset->kode . '.svg';

        // Periksa apakah file QR ada di disk 'public' (storage/app/public) dan hapus jika ada.
        if (Storage::disk('public')->exists($qrCodePath)) {
            Storage::disk('public')->delete($qrCodePath);
        }
        $asset->delete();

        return redirect()->route(match (auth()->user()->role) {
            'superadmin' => 'superadmin.assets.index',
            'admin'      => 'admin.assets.index',
            // 'user'       => 'user.assets.index', //user gak ada
            default      => 'login',
        })->with('success', 'Aset berhasil dihapus.');
    }

    /**
     * Display a public verification page for the asset.
     *
     * @param  \App\Models\Asset  $asset
     * @return \Illuminate\View\View
     */
    public function verifyAsset(Asset $asset)
    {
        $asset->load(['bergerak', 'tidakBergerak', 'habisPakai']);
        return view('aset.public_verify', compact('asset'));
    }
}
