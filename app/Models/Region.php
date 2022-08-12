<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'region';

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_region', 'region_id', 'product_id')
                    ->withPivot(['price_purchase', 'price_selling', 'price_discount']);
    }
}
