<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['product_id','user_id','quantity'];
    public function order(){
        return $this->belongsTo(Order::class);
    }
}
