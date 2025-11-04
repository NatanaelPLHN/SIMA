<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class AssetUsage extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'asset_usage';

    protected $fillable = [
        'asset_id',
        'used_by',
        'department_id',
        'start_date',
        'tujuan_penggunaan',
        'jumlah_digunakan',
        'status',
        'keterangan',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'string',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->useLogName('asset_activity')
            ->logOnly(['asset_id', 'used_by', 'department_id', 'status', 'start_date', 'end_date'])
            ->setDescriptionForEvent(function (string $eventName) {
                $assetName = $this->asset->nama_aset ?? 'Unknown Asset';
                $assetCode = $this->asset->kode ?? 'N/A';
                $userName = $this->user->nama ?? 'Unknown User';
                $status = $this->status ?? 'tidak diketahui';

                if ($eventName === 'created') {
                    return "Aset {$assetName} ({$assetCode}) telah dipinjam oleh {$userName} (status: {$status}).";
                } elseif ($eventName === 'updated') {
                    return "Data peminjaman untuk {$assetName} telah diperbarui (status: {$status}).";
                } elseif ($eventName === 'deleted') {
                    return "Peminjaman aset {$assetName} oleh {$userName} telah dihapus.";
                }

                return "Aktivitas peminjaman aset {$assetName} telah {$eventName}.";
            });
    }

    // Relationships
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id')->withDefault([
            'nama_aset' => 'Asset telah dihapus',
            'kode' => 'N/A',
            'status' => 'N/A',
        ]);
    }

    public function user()
    {
        return $this->belongsTo(Employee::class, 'used_by')->withDefault([
            'nama' => 'Employee telah dihapus',
            'nip' => 'N/A',
        ]);
    }

    public function department()
    {
        return $this->belongsTo(Departement::class, 'department_id')->withDefault([
            'nama' => 'Departement telah dihapus',
        ]);
    }

    public function getDurasiAttribute()
    {
        if ($this->end_date) {
            return $this->start_date->diffInDays($this->end_date);
        }

        return $this->start_date->diffInDays(now());
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'dipakai');
    }

    public function scopeReturned($query)
    {
        return $query->where('status', 'dikembalikan');
    }
}
