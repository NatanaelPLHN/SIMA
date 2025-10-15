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

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'instansi_id');
    }

    public function kepala()
    {
        return $this->belongsTo(Employee::class, 'kepala_bidang_id');
    }

    // employees in this department
    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id');
    }
    public function assetUsage()
    {
        return $this->hasMany(AssetUsage::class, 'department_id');
    }
}
