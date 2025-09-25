<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'category_group_id',
        'alias',
    ];


    // Relasi dengan category group
    public function categoryGroup()
    {
        return $this->belongsTo(CategoryGroup::class, 'category_group_id');
    }

    // Relasi dengan aset (barang_aset)
    public function assets()
    {
        return $this->hasMany(Asset::class, 'category_id'); // Sesuaikan dengan nama model aset Anda
    }

    // Scope untuk mendapatkan kategori utama (tanpa parent)


    // Scope untuk mendapatkan kategori berdasarkan group
    public function scopeByGroup($query, $groupId)
    {
        return $query->where('category_group_id', $groupId);
    }

    // Accessor untuk mendapatkan path kategori (breadcrumb)
    // public function getPathAttribute()
    // {
    //     $path = collect([$this->nama]);
    //     $parent = $this->parent;

    //     while ($parent) {
    //         $path->prepend($parent->nama);
    //         $parent = $parent->parent;
    //     }

    //     return $path->implode(' > ');
    // }
}