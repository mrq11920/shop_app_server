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

    public function largeCategory()
    {
        return $this->belongsTo(LargeCategory::class, 'large_category_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
}
