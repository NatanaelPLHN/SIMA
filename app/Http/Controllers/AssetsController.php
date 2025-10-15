<?php

namespace App\Http\Controllers;

use App\Exports\AssetActivityExport;
use App\Exports\SpecificActivityLogExport;
use App\Models\AsetBergerak;
use App\Models\AsetHabisPakai;
use App\Models\AsetTidakBergerak;
use App\Models\Asset;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Activitylog\Models\Activity;

class AssetsController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Asset::class, 'asset');
    }

    public function index()
    {
        $user = auth()->user();
        $assetsBergerak = Asset::where('jenis_aset', 'bergerak')->where('department_id', $user->employee?->department_id)->with(['bergerak', 'category.categoryGroup'])->paginate(10, ['*'], 'bergerak_page');
        $assetsTidakBergerak = Asset::where('jenis_aset', 'tidak_bergerak')->where('department_id', $user->employee?->department_id)->with(['tidakBergerak', 'category.categoryGroup'])->paginate(10, ['*'], 'tidak_bergerak_page');
        $assetsHabisPakai = Asset::where('jenis_aset', 'habis_pakai')->where('department_id', $user->employee?->department_id)->with(['habisPakai', 'category.categoryGroup'])->paginate(10, ['*'], 'habis_pakai_page');

        return view('aset.index', compact('assetsBergerak', 'assetsTidakBergerak', 'assetsHabisPakai'));
    }

    public function create_gerak()
    {
        $user = auth()->user();
        $department_id = $user->employee?->department?->id;
        if (isAsetLocked($department_id, 'bergerak')) {
            return redirect(routeForRole('assets', 'index'))->with('error', 'Tidak dapat menambah aset baru. Stock opname untuk jenis aset ini sedang berlangsung.');
        }
        // $groupCategories = CategoryGroup::with('categories')->get();
        $groupCategories = CategoryGroup::whereHas('categories')->with('categories')->get();

        return view('aset.forms.create_gerak', compact('groupCategories'));
    }

    public function create_tidak()
    {

        $user = auth()->user();
        $department_id = $user->employee?->department?->id;
        if (isAsetLocked($department_id, 'tidak_bergerak')) {
            return redirect(routeForRole('assets', 'index'))->with('error', 'Tidak dapat menambah aset baru. Stock opname untuk jenis aset ini sedang berlangsung.');
        }
        // $groupCategories = CategoryGroup::with('categories')->get();
        $groupCategories = CategoryGroup::whereHas('categories')->with('categories')->get();

        return view('aset.forms.create_tidak_bergerak', compact('groupCategories'));
    }

    public function create_habis()
    {
        $user = auth()->user();
        $department_id = $user->employee?->department?->id;
        if (isAsetLocked($department_id, 'habis_pakai')) {
            return redirect(routeForRole('assets', 'index'))->with('error', 'Tidak dapat menambah aset baru. Stock opname untuk jenis aset ini sedang berlangsung.');
        }
        // $groupCategories = CategoryGroup::with('categories')->get();
        $groupCategories = CategoryGroup::whereHas('categories')->with('categories')->get();

        return view('aset.forms.create_habis', compact('groupCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_aset' => 'required',
            'jenis_aset' => 'required|in:bergerak,tidak_bergerak,habis_pakai',
            'category_id' => 'required|exists:categories,id',
            'jumlah' => 'nullable|integer|min:0',
            'tgl_pembelian' => 'required|date|before_or_equal:today',
            'nilai_pembelian' => 'required|numeric|min:0',
            'lokasi_terakhir' => 'required|string',
            'status' => 'nullable|in:tersedia,dipakai,rusak,hilang,habis',
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
        $department_id = $user->employee?->department?->id;
        if (isAsetLocked($department_id, $validated['jenis_aset'])) {
            return redirect(routeForRole('assets', 'index'))->with('error', 'Tidak dapat menambah aset baru. Stock opname untuk jenis aset ini sedang berlangsung.');
        }

        // LOGIKA BARU SESUAI JENIS ASET
        if ($validated['jenis_aset'] === 'habis_pakai') {
            $validated['status'] = ($validated['jumlah'] == 0) ? 'habis' : 'tersedia';
        } else { // Untuk 'bergerak' dan 'tidak_bergerak'
            $validated['jumlah'] = ($request->status === 'hilang') ? 0 : 1;
        }

        $institutionAlias = $user->employee?->department?->institution?->alias;
        $departmentAlias = $user->employee?->department?->alias;

        $category = Category::find($request->category_id);
        $categoryGroupAlias = $category->categoryGroup?->id; // category group alias = ID
        $categoryAlias = $category->id; // category alias = ID

        $lastAsset = Asset::where('department_id', $user->employee?->department?->id)
            ->where('category_id', $validated['category_id'])
            ->latest('id')
            ->first();

        $nextNumber = 1;
        if ($lastAsset) {
            $parts = explode('-', $lastAsset->kode);
            $lastNumber = (int) end($parts);
            $nextNumber = $lastNumber + 1;
        }

        $kode = implode('-', [
            $institutionAlias,
            $departmentAlias,
            $categoryGroupAlias,
            $categoryAlias,
            $nextNumber,
        ]);

        $department_id = $user->employee?->department?->id;
        $validated['department_id'] = $department_id;
        $validated['kode'] = $kode;

        // Use DB transaction. Generate QR only AFTER successful commit to avoid orphan files.
        DB::beginTransaction();
        try {
            $asset = Asset::create($validated);

            // handle details table (create records inside transaction, but don't write QR file yet)
            if ($validated['jenis_aset'] === 'bergerak') {
                $assetBergerak = AsetBergerak::create([
                    'aset_id' => $asset->id,
                    'merk' => $request->merk,
                    'tipe' => $request->tipe,
                    'nomor_serial' => $request->nomor_serial,
                    'tahun_produksi' => $request->tahun_produksi,
                    // qr_code_path will be set after commit
                ]);
            }

            if ($validated['jenis_aset'] === 'tidak_bergerak') {
                $assetTidak = AsetTidakBergerak::create([
                    'aset_id' => $asset->id,
                    'ukuran' => $request->ukuran,
                    'bahan' => $request->bahan,
                    // qr_code_path will be set after commit
                ]);
            }

            if ($validated['jenis_aset'] === 'habis_pakai') {
                AsetHabisPakai::create([
                    'aset_id' => $asset->id,
                    'register' => $request->register,
                    'satuan' => $request->satuan,
                ]);
            }

            DB::commit();

            // After commit -> generate QR and update the bergerak/tidak_bergerak record with path
            if ($validated['jenis_aset'] === 'bergerak') {
                $qrCodePath = 'qrcodes/'.$asset->kode.'.svg';
                $fullPath = storage_path('app/public/'.$qrCodePath);

                if (! file_exists(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0755, true);
                }
                QrCode::format('svg')->size(200)->generate(route('asset.public.verify', $asset->kode), $fullPath);

                // update the bergerak record
                $asset->bergerak()->update(['qr_code_path' => $qrCodePath]);
            }

            if ($validated['jenis_aset'] === 'tidak_bergerak') {
                $qrCodePath = 'qrcodes/'.$asset->kode.'.svg';
                $fullPath = storage_path('app/public/'.$qrCodePath);

                if (! file_exists(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0755, true);
                }
                QrCode::format('svg')->size(200)->generate(route('asset.public.verify', $asset->kode), $fullPath);

                $asset->tidakBergerak()->update(['qr_code_path' => $qrCodePath]);
            }

            return redirect(routeForRole('assets', 'index'))->with('success', 'Aset berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to store asset: '.$e->getMessage(), ['exception' => $e]);

            return back()->withInput()->with('error', 'Gagal menambahkan aset. Silakan coba lagi.');
        }
    }

    public function show(Asset $asset)
    {
        $user = auth()->user();

        $asset->load(['bergerak', 'tidakBergerak', 'habisPakai', 'category.categoryGroup']);

        if ($asset->department_id != $user->employee->department_id) {
            abort(404);
        }

        $logs = Activity::where('subject_type', Asset::class)
            ->where('subject_id', $asset->id)
            ->latest()
            ->paginate(10);

        switch ($asset->jenis_aset) {
            case 'bergerak':
                return view('aset.details.bergerak', compact('asset', 'logs'));
            case 'tidak_bergerak':
                return view('aset.details.tidak_bergerak', compact('asset', 'logs'));
            case 'habis_pakai':
                return view('aset.details.habis', compact('asset', 'logs'));
            default:
                abort(404);
        }
    }

    public function edit(Asset $asset)
    {

        $user = auth()->user();
        $department_id = $user->employee?->department?->id;
        if (isAsetLocked($department_id, $asset->jenis_aset)) {
            return redirect(routeForRole('assets', 'index'))->with('error', 'Tidak dapat mengedit data aset. Stock opname untuk jenis aset ini sedang berlangsung.');
        }

        $asset->load(['bergerak', 'tidakBergerak', 'habisPakai', 'category.categoryGroup']);

        if ($asset->department_id != $user->employee->department_id) {
            abort(404);
            // return redirect(routeForRole('assets', 'index'))->with('error', 'Tidak dapat mengedit data aset. Stock opname untuk jenis aset ini sedang berlangsung.');
        }
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
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'nama_aset' => 'required',
            'category_id' => 'required|exists:categories,id',
            'jumlah' => 'nullable|integer|min:0',
            'tgl_pembelian' => 'nullable|date',
            'nilai_pembelian' => 'nullable|numeric',
            'lokasi_terakhir' => 'nullable|string',
            'status' => 'nullable|in:tersedia,dipakai,rusak,hilang,habis',
        ]);

        // LOGIKA BARU SESUAI JENIS ASET
        if ($asset->jenis_aset === 'habis_pakai') {
            $validated['status'] = ($request->jumlah == 0) ? 'habis' : 'tersedia';
        } else { // Untuk 'bergerak' dan 'tidak_bergerak'
            $validated['jumlah'] = ($request->status === 'hilang') ? 0 : 1;
        }

        DB::beginTransaction();
        try {
            $original = $asset->replicate();
            $asset->fill($validated);
            $detailModel = null;
            if ($asset->jenis_aset === 'bergerak') {
                $asset->bergerak->fill($request->only([
                    'merk',
                    'tipe',
                    'nomor_serial',
                    'tahun_produksi',
                ]));
                $detailModel = $asset->bergerak;
            } elseif ($asset->jenis_aset === 'tidak_bergerak') {
                $asset->tidakBergerak->fill($request->only(['ukuran', 'bahan']));
                $detailModel = $asset->tidakBergerak;
            } elseif ($asset->jenis_aset === 'habis_pakai') {
                $asset->habisPakai->fill($request->only(['register', 'satuan']));
                $detailModel = $asset->habisPakai;
            }

            // 2. Cek apakah ADA PERUBAHAN di model utama ATAU di model detailnya
            $isAssetDirty = $asset->isDirty();
            $isDetailDirty = $detailModel ? $detailModel->isDirty() : false;

            if (! $isAssetDirty && ! $isDetailDirty) {
                DB::rollBack();

                return back()->with('info', 'Tidak ada perubahan pada data aset.');
            }

            // 3. Jika ada perubahan, simpan semuanya
            if ($isAssetDirty) {
                $asset->save();
            }
            if ($isDetailDirty) {
                $detailModel->save();
            }

            DB::commit();

            return redirect(routeForRole('assets', 'index'))->with('success', 'Aset berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update asset: '.$e->getMessage(), ['exception' => $e, 'asset_id' => $asset->id]);

            return back()->withInput()->with('error', 'Gagal memperbarui aset. Silakan coba lagi.');
        }
    }

    public function destroy(Asset $asset)
    {
        $user = auth()->user();
        $department_id = $user->employee?->department?->id;
        if (isAsetLocked($department_id, $asset->jenis_aset)) {
            return redirect(routeForRole('assets', 'index'))->with('error', 'Tidak dapat menghapus data aset. Stock opname untuk jenis aset ini sedang berlangsung.');
        }
        // determine QR code path
        $qrCodePath = 'qrcodes/'.$asset->kode.'.svg';

        DB::beginTransaction();
        try {
            $asset->delete();
            DB::commit();

            // delete QR file after successful DB deletion
            if (Storage::disk('public')->exists($qrCodePath)) {
                Storage::disk('public')->delete($qrCodePath);
            }

            return redirect(routeForRole('assets', 'index'))->with('success', 'Aset berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete asset: '.$e->getMessage(), ['exception' => $e, 'asset_id' => $asset->id]);

            return redirect(routeForRole('assets', 'index'))->with('error', 'Gagal menghapus Aset. Aset masih memiliki data peminjaman atau terjadi kesalahan.');
        }
    }

    public function verifyAsset(Asset $asset)
    {
        $asset->load(['bergerak', 'tidakBergerak', 'habisPakai']);

        return view('aset.public_verify', compact('asset'));
    }

    public function exportAssetLog(Asset $asset)
    {
        $fileName = 'Log_Aset_'.str_replace(' ', '_', $asset->nama_aset).'_'.now()->format('Ymd_His').'.xlsx';

        return Excel::download(new SpecificActivityLogExport($asset->id), $fileName);
    }
}
