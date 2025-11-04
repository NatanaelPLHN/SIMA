<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;


class StockOpnameDetail extends Model
{
    use HasFactory;

    protected $table = 'stock_opname_details';

    protected $fillable = [
        'aset_id',
        'jumlah_sistem',
        'jumlah_fisik',
        'status_lama',
        'status_fisik',
        'checked_by',
        'stock_opname_id',
        'surat_kehilangan_path',
    ];

    // Belongs to a stock opname session
    public function stockOpname()
    {
        return $this->belongsTo(StockOpnameSession::class, 'stock_opname_id');
        // return $this->belongsTo(StockOpname::class, 'stock_opname_id');
    }

    // Asset being checked
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'aset_id');
    }

    // The user who actually checked the asset
    public function checker()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
    public function getSuratKehilanganUrlAttribute()
    {
        if (!$this->surat_kehilangan_path) {
            return null;
        }
        // pastikan Anda menyimpan di disk 'public' atau sesuaikan disknya
        return Storage::disk('public')->url($this->surat_kehilangan_path);
    }

}
