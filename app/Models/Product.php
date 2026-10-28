<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ★【追記1】これを追加します

class Product extends Model
{
    use HasFactory;
    use SoftDeletes; // ★【追記2】これを追加します

    // 1つの商品は1つの仕入先に属する
    public function vendor() {
        return $this->belongsTo(Vendor::class, 'vendor_code', 'vendor_code');
    }    
}