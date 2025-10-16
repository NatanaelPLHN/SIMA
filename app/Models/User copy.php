<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserCopy extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'role',
        'karyawan_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    // Method untuk mengecek role

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'karyawan_id');
    }


    // User scheduled stock opnames
    public function scheduledStockOpnames()
    {
        return $this->hasMany(StockOpname::class, 'scheduled_by');
    }

    // User performed checks (as checker)
    public function stockOpnameDetails()
    {
        return $this->hasMany(StockOpnameDetail::class, 'checked_by');
    }

    public function isSuperAdmin()
    {
        return $this->role === 'superadmin';
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSubAdmin()
    {
        return $this->role === 'subadmin';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    // public function departemen()
    // {
    //     return $this->employee?->departemen();
    // }

    // // shortcut untuk akses langsung instansi
    // public function instansi()
    // {
    //     return $this->employee?->departemen?->instansi();
    // }
    public function getInstansiNamaAttribute()
    {
        return $this->employee?->departemen?->instansi?->nama;
    }

    public function getDepartemenNamaAttribute()
    {
        return $this->employee?->departemen?->nama;
    }
}
