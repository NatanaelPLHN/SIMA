<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StockOpnameDetail;
use App\Models\Asset;
use App\Models\Departement;
use App\Models\CategoryGroup;
use App\Models\User;
use App\Models\StockOpnameSession;
use Illuminate\Support\Facades\DB;

class StockOpnameDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = auth()->user();
        $sessions = StockOpnameSession::with(['scheduler','details'])
        ->latest()
        ->paginate(10);




        return view('opname.bidang.index', compact('sessions','user'));
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
    // public function update(Request $request, StockOpnameSession $opname)
    //   {
    //       $request->validate([
    //           'statuses' => 'required|array',
    //           'statuses.*' => 'nullable|string|in:tersedia,dipakai,rusak,hilang,habis',
    //       ]);

    //       foreach ($request->statuses as $detailId => $status) {
    //           // Hanya update jika statusnya dipilih (tidak kosong)
    //           if (!empty($status)) {
    //               StockOpnameDetail::where('id', $detailId)
    //                   // Pastikan detail ini milik sesi opname yang benar untuk keamanan
    //                   ->where('stock_opname_id', $opname->id)
    //                   ->update(['status_fisik' => $status]);
    //           }
    //       }

    //       // Tandai sesi sebagai 'selesai' setelah semua detail diupdate
    //       $opname->status = 'selesai';
    //       $opname->tanggal_selesai = now();
    //       $opname->save();

    //       return redirect()->route('admin.opname.show', $opname->id)->with('success', 'Stock opname berhasil disimpan dan diselesaikan.');
    //   }



    //   public function update(Request $request, StockOpnameSession $opname)
    //   {
    //       $request->validate([
    //           'statuses' => 'required|array',
    //           'statuses.*' => 'nullable|string',
    //           'jumlah_fisik' => 'required|array',
    //           'jumlah_fisik.*' => 'required|integer|min:0',
    //       ]);

    //       // Gunakan transaksi database untuk memastikan semua query berhasil atau tidak sama sekali
    //       DB::beginTransaction();
    //       try {
    //           foreach ($request->statuses as $detailId => $status) {
    //               $jumlahFisik = $request->jumlah_fisik[$detailId];

    //               // 1. Ambil detail opname yang valid
    //               $detail = StockOpnameDetail::where('id', $detailId)
    //                   ->where('stock_opname_id', $opname->id)
    //                   ->firstOrFail(); // Gagal jika detail tidak ditemukan

    //               // 2. Update tabel stock_opname_details
    //               $detail->jumlah_fisik = $jumlahFisik;
    //               $detail->status_fisik = $status;
    //               $detail->checked_by = auth()->id(); // Catat siapa yang melakukan update
    //               $detail->save();

    //               // 3. Update tabel assets
    //               $asset = $detail->asset; // Ambil relasi asset dari detail
    //               if ($asset) {
    //                   $asset->jumlah = $jumlahFisik;
    //                   // Untuk aset tetap, status opname bisa memengaruhi status utama aset
    //                   if ($asset->jenis_aset != 'habis_pakai') {
    //                       // Logika sederhana: jika status opname 'rusak' atau 'hilang',
    //                       // update juga status utama aset.
    //                       if (in_array($status, ['rusak', 'hilang'])) {
    //                           $asset->status = $status;
    //                       } else {
    //                           $asset->status = 'tersedia'; // atau 'dipakai' jika ada logika peminjaman
    //                       }
    //                   }
    //                   $asset->save();
    //               }
    //           }

    //           // 4. Tandai sesi sebagai 'selesai'
    //           $opname->status = 'selesai';
    //           $opname->tanggal_selesai = now();
    //           $opname->save();

    //           // Jika semua berhasil, commit transaksi
    //           DB::commit();

    //           return redirect()->route('admin.opname.index', $opname->id)->with('success', 'Stock opname berhasil disimpan dan data aset telah diperbarui.');

    //       } catch (\Exception $e) {
    //           // Jika terjadi error, batalkan semua perubahan
    //           DB::rollBack();
    //           // Optional: catat errornya
    //           // Log::error('Gagal menyelesaikan stock opname: ' . $e->getMessage());

    //           return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data. Semua perubahan
    //   telah dibatalkan.');
    //       }
    //   }


    public function update(Request $request, StockOpnameSession $opname)
  {
      $request->validate([
          'statuses' => 'required|array',
          'statuses.*' => 'nullable|string',
          'jumlah_fisik' => 'required|array',
          'jumlah_fisik.*' => 'required|integer|min:0',
      ]);

      DB::beginTransaction();
      try {
          foreach ($request->statuses as $detailId => $statusFisik) {
              // Jika tidak ada status yang dipilih untuk aset bergerak/tetap, lewati
              if (empty($statusFisik)) {
                  continue;
              }

              $jumlahFisik = $request->jumlah_fisik[$detailId];

              // 1. Ambil detail opname yang valid beserta relasi asetnya
              $detail = StockOpnameDetail::with('asset')->where('id', $detailId)
                  ->where('stock_opname_id', $opname->id)
                  ->firstOrFail();

              $asset = $detail->asset;
              if (!$asset) {
                  continue; // Lewati jika aset tidak ditemukan
              }

              // Simpan status dan jumlah lama dari tabel assets sebelum diubah
              $statusSistemLama = $asset->status;

              // 2. Update tabel stock_opname_details dengan hasil pengecekan
              $detail->jumlah_fisik = $jumlahFisik;
              $detail->status_fisik = $statusFisik;
            //   $detail->checked_by = auth()->id();
              $detail->save();

              // 3. Terapkan logika update ke tabel assets utama
              if ($asset->jenis_aset == 'bergerak' || $asset->jenis_aset == 'tidak_bergerak') {
                  // Logika untuk aset tetap (berdasarkan perubahan status)
                  $isNowLostOrBroken = in_array($statusFisik, ['hilang', 'rusak']);
                  $wasPreviouslyNormal = !in_array($statusSistemLama, ['hilang', 'rusak']);

                  // Kurangi jumlah (set jadi 0) hanya jika status berubah dari normal menjadi hilang/rusak
                  if ($isNowLostOrBroken && $wasPreviouslyNormal) {
                      $asset->jumlah = 0;
                  }

                  // Selalu update status utama aset sesuai hasil opname
                  $asset->status = $statusFisik;

              } else { // Logika untuk aset habis pakai (berdasarkan input jumlah)
                  $asset->jumlah = $jumlahFisik;
                  if ($asset->jumlah == 0) {
                      $asset->status = 'habis';
                  } else {
                      $asset->status = 'tersedia'; // Jika jumlah diisi kembali, pastikan statusnya tersedia
                  }
              }

              $asset->save();
          }

          // 4. Tandai sesi opname sebagai 'selesai'
          $opname->status = 'selesai';
          $opname->tanggal_selesai = now();
          $opname->save();

          DB::commit();

          return redirect()->route('admin.opname.show', $opname->id)->with('success', 'Stock opname berhasil disimpan dan data aset telah diperbarui.');

      } catch (\Exception $e) {
          DB::rollBack();
          // Baris di bawah ini sangat membantu saat development untuk melihat error
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




}
