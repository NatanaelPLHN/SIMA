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
        'department_id',
    ];

    // Relasi dengan Peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'borrowed_by');
    }
    // Relasi dengan Bidang (Department)
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'department_id');
    }
    // Relasi dengan user
    public function user()
    {
        return $this->hasOne(User::class, 'employee_id');
    }
}
