<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateList extends Model
{
    
    use HasFactory;
    protected $fillable=[
        'range_from','range_to', 'i_normal','i_urgent','product_id','c_normal','c_urgent','c_discount','i_discount'
    ];

    public function product(){
        return $this->belingsTo(Product::class);
    }
    
}
