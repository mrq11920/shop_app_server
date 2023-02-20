<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LargeCategory extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'icon',
        'created_at',
        'updated_at',
    ];

    public function largeCategories()
    {
        return $this->hasMany(SmallCategory::class, 'large_category_id', 'id');
    }
}
