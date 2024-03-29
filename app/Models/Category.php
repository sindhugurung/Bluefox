<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;


class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', //'slug',
     'parent_id'];

    public function scopeRoot($query){
        $query-> whereNull('parent_id');
    }

    public function children(){
        return $this ->hasMany(Category::class,'parent_id'
    );
}

public function product(){
   return $this->hasMany(Product::class);
}
   
    
}
