<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    protected $table = 'institutions';

    protected $fillable = [
        'nama',
        'pemerintah',
        'telepon',
        'email',
        'alamat',
        'alias',
        'kepala_instansi_id',
    ];

    public function departements()
    {
        return $this->hasMany(Departement::class, 'instansi_id');
    }

    // all employees directly under this institution (including kepala instansi)
    public function employees()
    {
        return $this->hasMany(Employee::class, 'institution_id');
    }

    public function kepala()
    {
        return $this->belongsTo(Employee::class, 'kepala_instansi_id');
    }
}
