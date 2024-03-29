<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'name',
        'parent_id'
    ];

    public function tour()
    {
        return $this->hasMany(Tour::class, 'cate_id', 'id');
    }

    public function scopeFullTextSearch($query, $input)
    {
        return $query->Where('name', 'like', '%' . $input . '%')
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();
    }
    public function cateParent(){
        return $this->hasMany(Category::class, 'parent_id');
    }
}
