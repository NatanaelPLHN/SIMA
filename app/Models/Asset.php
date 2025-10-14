<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Asset extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'aset';

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('aset')
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) =>
                "Aset {$this->nama_aset} dengan kode {$this->kode} telah {$eventName}");
    }

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

}
