<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class assets extends Model
{
        /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'department',
        'quantity',
        'status',
        'description',
    ];
}
