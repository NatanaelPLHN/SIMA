<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Asset extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'aset';

    // ✅ Flag to disable Spatie logging temporarily
    public static bool $suppressLogging = false;

    protected $fillable = [
        'kode',
        'nama_aset',
        'jenis_aset',
        'category_id',
        'jumlah',
        'tgl_pembelian',
        'nilai_pembelian',
        'lokasi_terakhir',
        'status',
        'department_id',
    ];

    protected static function booted()
    {
        static::updating(function ($model) {
            if (self::$suppressLogging) {
                activity()->disableLogging();
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('asset_activity')
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(function (string $eventName) {
                $assetName = $this->nama_aset ?? 'Unknown Asset';
                $assetCode = $this->kode ?? 'N/A';
                $status = $this->status ?? 'tidak diketahui';
                $category = $this->category->name ?? 'Tanpa Kategori';
                $dept = $this->departement->name ?? 'Tanpa Departemen';

                switch ($eventName) {
                    case 'created':
                        return "Aset baru telah ditambahkan: {$assetName} ({$assetCode}), kategori {$category}, status {$status}, departemen {$dept}.";

                    case 'updated':
                        return "Aset {$assetName} ({$assetCode}) telah diperbarui. Status saat ini: {$status}.";

                    case 'deleted':
                        return "Aset {$assetName} ({$assetCode}) telah dihapus dari sistem.";

                    default:
                        return "Aset {$assetName} ({$assetCode}) mengalami perubahan: {$eventName}.";
                }
            });
    }

    // --- relationships ---

    public function bergerak()
    {
        return $this->hasOne(AsetBergerak::class, 'aset_id');
    }

    public function tidakBergerak()
    {
        return $this->hasOne(AsetTidakBergerak::class, 'aset_id');
    }

    public function habisPakai()
    {
        return $this->hasOne(AsetHabisPakai::class, 'aset_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'department_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Borrowing::class, 'aset_id');
    }

    public function stockOpnameDetails()
    {
        return $this->hasMany(StockOpnameDetail::class, 'aset_id');
    }

    public function usage()
    {
        return $this->hasMany(AssetUsage::class, 'asset_id');
    }

    public function currentUsage()
    {
        return $this->hasOne(AssetUsage::class, 'asset_id')
            ->where('status', 'dipakai')
            ->latest();
    }
}
