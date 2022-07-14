<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class feedback extends Model
{
    use HasFactory;
    protected $fillable = [
        'feedback_desc',
        'user_id',
        'order_id',
        'feedback_title'
    ];
}
