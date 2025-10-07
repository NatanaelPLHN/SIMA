<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees';

    protected $fillable = [
        'nip',
        'nama',
        'alamat',
        'telepon',
        'institution_id', // kepala instansi
        'department_id',  // kepala bidang or regular pegawai
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function department()
    {
        return $this->belongsTo(Departement::class, 'department_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'karyawan_id');
    }
}

