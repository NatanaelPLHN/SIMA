<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetUsage extends Model
{
    use HasFactory;

    protected $table = 'asset_usage';

    protected $fillable = [
        'asset_id',
        'used_by',
        'department_id',
        'start_date',
        'tujuan_penggunaan',
        'status',
        'keterangan',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'string',
    ];

    // Relasi dengan Asset
    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id')->withDefault([
            'nama_aset' => 'Asset telah dihapus',
            'kode' => 'N/A',
            'status' => 'N/A'
        ]);
    }

    // Relasi dengan Employee (Pengguna)
    public function user()
    {
        return $this->belongsTo(Employee::class, 'used_by')->withDefault([
            'nama' => 'Employee telah dihapus',
            'nip' => 'N/A'
        ]);
    }

    // Relasi dengan Departement
    public function department()
    {
        return $this->belongsTo(Departement::class, 'department_id')->withDefault([
            'nama' => 'Departement telah dihapus'
        ]);
    }

    // Accessor untuk durasi penggunaan
    public function getDurasiAttribute()
    {
        if ($this->end_date) {
            return $this->start_date->diffInDays($this->end_date);
        }

        return $this->start_date->diffInDays(now());
    }

    // Scope untuk penggunaan aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'in_use');
    }

    // Scope untuk penggunaan yang sudah dikembalikan
    public function scopeReturned($query)
    {
        return $query->where('status', 'returned');
    }
}