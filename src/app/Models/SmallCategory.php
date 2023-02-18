<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmallCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'large_category_id',
        'created_at',
        'updated_at',
    ];
}
