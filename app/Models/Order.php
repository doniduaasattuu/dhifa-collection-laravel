<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasUuids;

    protected $table = "orders";
    protected $primaryKey = "id";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        "id",
        "email",
        "order_date",
        "shopping_total",
        "status"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "email", "email");
    }

    public function order_details(): HasMany
    {
        return $this->hasMany(OrderDetail::class, "order_id", "id");
    }
}
