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
    ];
    public function bidang()
    {
        return $this->hasMany(Departement::class, 'instansi_id');
    }
}
