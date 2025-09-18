<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'bidang';

    protected $fillable = [
        'nama',
        'kepala_bidang',
        'lokasi',
        'instansi_id',
    ];

    // Relasi dengan Instansi
    public function instansi()
    {
        return $this->belongsTo(Instansi::class, 'instansi_id');
    }

    // Relasi dengan Employee (Kepala Bidang)
    public function kepala()
    {
        return $this->belongsTo(Employee::class, 'kepala_bidang');
    }

    // Relasi dengan Employee (Anggota Bidang)
    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }
}