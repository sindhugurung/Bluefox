<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateList extends Model
{
    use HasFactory;
    protected $fillable=[
        'quantity', 'normal_price','urgent_price','product_id','discount',
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
