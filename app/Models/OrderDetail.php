<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderDetail extends Model
{
    protected $table = "order_details";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = false;

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, "order_id", "id");
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, "id", "product_id");
    }

    protected $fillable = [
        "id",
        "order_id",
        "product_id",
        "price",
        "qty",
        "amount",
    ];
}
