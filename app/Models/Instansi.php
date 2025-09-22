<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instansi extends Model
{
    use HasFactory;

    protected $table = 'instansi';

    protected $fillable = [
        'nama',
        'pemerintah',
        'no_telp',
        'email',
        'alamat',
    ];
    public function bidang()
    {
        return $this->hasMany(Bidang::class, 'instansi_id');
    }
}
