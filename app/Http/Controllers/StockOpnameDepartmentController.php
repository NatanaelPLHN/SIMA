<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\StockOpnameDetail;
use App\Models\Asset;
use App\Models\Departement;
use App\Models\CategoryGroup;
use App\Models\User;
use App\Models\StockOpnameSession;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Facades\DB;

class StockOpnameDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = auth()->user();
        $sessions = StockOpnameSession::with(['scheduler', 'details'])
            ->latest()
            ->paginate(10);




        return view('opname.bidang.index', compact('sessions', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StockOpnameSession $opname)
    {
        if (in_array($opname->status, ['draft', 'cancelled','dijadwalkan'])) {
            abort(404);
        }
        // Gunakan $opname karena route model binding
        $opname->load(['details', 'scheduler']); // Eager load relasi untuk efisiensi
        return view('opname.bidang.show', compact('opname'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, StockOpnameSession $opname)
    {
        // Validasi dasar untuk memastikan input yang diharapkan ada dan berupa array
        $request->validate([
            'statuses' => 'nullable|array',
            'jumlah_fisik' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            // Loop melalui koleksi 'details' yang ada pada sesi opname ini.
            // Ini adalah sumber kebenaran yang paling andal.
            foreach ($opname->details as $detail) {
                $asset = $detail->asset;
                if (!$asset) {
                    continue; // Lewati jika karena suatu hal aset tidak terhubung
                }

                $detailId = $detail->id;
                $assetType = $asset->jenis_aset;

                if ($assetType === 'bergerak' || $assetType === 'tidak_bergerak') {
                    // Cek apakah ada input status untuk detail ID ini
                    if ($request->has("statuses.{$detailId}") && !empty($request->statuses[$detailId])) {
                        $statusFisikInput = $request->statuses[$detailId];

                        // Terapkan logika: status fisik menentukan jumlah fisik
                        $detail->status_fisik = $statusFisikInput;
                        $asset->status = $statusFisikInput;

                        $jumlahFisikHasil = ($statusFisikInput === 'hilang') ? 0 : 1;
                        $detail->jumlah_fisik = $jumlahFisikHasil;
                        $asset->jumlah = $jumlahFisikHasil;

                        // $detail->checked_by = auth()->id();
                        $detail->save();
                        $asset->save();
                    }
                    // Jika tidak ada input status, jangan lakukan apa-apa untuk aset ini.

                } elseif ($assetType === 'habis_pakai') {
                    // Cek apakah ada input jumlah fisik untuk detail ID ini
                    if ($request->has("jumlah_fisik.{$detailId}")) {
                        $jumlahFisikInput = (int) $request->jumlah_fisik[$detailId];

                        // Terapkan logika: jumlah fisik menentukan status fisik
                        $detail->jumlah_fisik = $jumlahFisikInput;
                        $asset->jumlah = $jumlahFisikInput;

                        // if ($asset->habisPakai) {
                        //     $asset->habisPakai->update(['jumlah' => $jumlahFisikInput]);
                        // }

                        $statusFisikHasil = ($jumlahFisikInput == 0) ? 'habis' : 'tersedia';
                        $detail->status_fisik = $statusFisikHasil;
                        $asset->status = $statusFisikHasil;

                        // $detail->checked_by = auth()->id();
                        $detail->save();
                        $asset->save();
                    }
                    // Jika tidak ada input jumlah, jangan lakukan apa-apa untuk aset ini.
                }
            }

            // Selesaikan sesi opname setelah loop selesai
            $opname->status = 'selesai';
            $opname->tanggal_selesai = now();
            $opname->save();

            DB::commit();

            return redirect(routeForRole('opname', 'index', $opname->id))->with('success', 'Stock opname berhasil disimpan dan data aset telah diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function complete(Request $request, StockOpnameSession $opname)
    {
        $validated = $request->validate([
            'catatan' => 'nullable|string',

        ]);
        if ($opname->status !== 'draft') {
            return redirect()->back()
                ->with('error', 'Sesi hanya bisa dimulai jika statusnya draft.');
        }


        $opname->update([
            'status' => 'dijadwalkan',
            'catatan' => $request->catatan ?? 'Stock opname untuk ' . $opname->departement->nama,

        ]);

        return redirect()->back()->with('success', 'Sesi stock opname berhasil dimulai.');
    }

    public function getAssetDetailsByCode(string $kode): JsonResponse
    {
        // Cari aset berdasarkan kode. Gunakan first() untuk mendapatkan satu objek.
        $asset = Asset::where('kode', $kode)->first();

        if (!$asset) {
            // Jika aset tidak ditemukan, kembalikan respons 404 Not Found
            return response()->json(['message' => 'Aset tidak ditemukan'], 404);
        }

        // Jika ditemukan, kembalikan data yang relevan
        return response()->json([
            'id' => $asset->id,
            'kode' => $asset->kode,
            'nama_aset' => $asset->nama_aset,
            'jenis_aset' => $asset->jenis_aset,
        ]);
    }
    public function startOpname(StockOpnameSession $session)
    {
        // Hanya ubah status jika masih 'dijadwalkan' untuk mencegah perubahan ganda
        if ($session->status === 'dijadwalkan') {
            $session->status = 'proses';
            $session->tanggal_dimulai = now();
            $session->save();

            return response()->json(['message' => 'Sesi opname berhasil dimulai.']);
        }

        // Jika statusnya bukan 'dijadwalkan' (misal sudah 'proses' atau 'selesai')
        return response()->json(['message' => 'Sesi opname sudah berjalan atau telah selesai.'], 409); // 409 Conflict
    }
    public function verifyPassword(Request $request)
    {
        // Validasi bahwa password ada di request
        $request->validate([
            'password' => 'required|string',
        ]);

        // Ambil pengguna yang sedang terautentikasi
        $user = Auth::user();

        // Periksa apakah password yang diberikan cocok dengan password pengguna
        if (Hash::check($request->password, $user->password)) {
            // Jika cocok, kembalikan respons sukses
            return response()->json(['message' => 'Password terverifikasi.'], 200);
        }

        // Jika tidak cocok, kembalikan respons error
        return response()->json(['message' => 'Password yang Anda masukkan salah.'], 422); // 422 Unprocessable Entity
    }
}
