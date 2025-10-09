<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockOpnameSession extends Model
{
    use HasFactory;

    protected $table = 'stock_opname_sessions';

    protected $fillable = [
        'nama',
        'scheduled_by',
        'departement_id',
        'tanggal_dijadwalkan',
        'tanggal_dimulai',
        'tanggal_selesai',
        'status',
        'catatan',
        // 'stock_opname_id',

    ];
    protected $casts = [
        'tanggal_dijadwalkan' => 'datetime',
        'tanggal_dimulai' => 'datetime',
        'tanggal_selesai' => 'datetime',
    ];

    // The user who scheduled the opname
    public function scheduler()
    {
        return $this->belongsTo(User::class, 'scheduled_by');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }

    // All details of assets checked in this opname
    public function details()
    {
        return $this->hasMany(StockOpnameDetail::class, 'stock_opname_id');
    }
}
