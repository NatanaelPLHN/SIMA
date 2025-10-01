<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    protected $table = 'departements';

    protected $fillable = [
        'nama',
        'kepala_bidang_id',
        'lokasi',
        'instansi_id',
        'alias',
    ];

    // Relasi dengan Instansi
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'instansi_id');
    }

    // Relasi dengan Karyawan (Kepala Bidang)
    public function kepala()
    {
        return $this->belongsTo(Employee::class, 'kepala_bidang_id');
    }

    // Relasi dengan Karyawan (Anggota Bidang)
    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }

    // Relasi dengan Karyawan (Anggota Bidang)
    public function opnameSession()
    {
        return $this->hasMany(StockOpnameSession::class, 'departement_id');
    }
}
