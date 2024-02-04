<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner',
        'shop_name',
        'phone',
        'email',
        'address',
        'description',
        'fb_link',
        'tw_link',
        'insta_link',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
