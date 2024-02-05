<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FlashSaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'show_at_home',
        'status',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeHomeActive($query)
    {
        return $query->where('show_at_home', 1)->where('status', 1);
    }
}
