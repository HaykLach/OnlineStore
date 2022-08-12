<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'name',
        'description'
    ];


    public $timestamps = false;

    public function region()
    {
        return $this->belongsToMany(Region::class, 'product_region', 'product_id', 'region_id')
                    ->withPivot(['price_purchase', 'price_selling', 'price_discount']);
    }
}
