<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryGroup extends Model
{
    use HasFactory;

    protected $table = 'category_groups';

    protected $fillable = [
        'nama',
        'deskripsi',
        'alias',
    ];

    // Relasi dengan categories (one to many)
    public function categories()
    {
        return $this->hasMany(Category::class, 'category_group_id');
    }

    // Mutator untuk membuat alias otomatis
    public function setAliasAttribute($value)
    {
        $this->attributes['alias'] = strtolower(str_replace(' ', '-', $value));
    }
}