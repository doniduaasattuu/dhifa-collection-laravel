<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    protected $table = "users";
    protected $primaryKey = "email";
    protected $keyType = "string";
    public $incrementing = false;
    public $timestamps = false;

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, "email", "email");
    }

    public function order_open(): HasOne
    {
        return $this->hasOne(Order::class, "email", "email")
            ->where("status", "=", "Open");
    }

    public function order_checkout(): HasOne
    {
        return $this->hasOne(Order::class, "email", "email")
            ->where("status", "=", "Checkout");
    }

    public function order_verified(): HasOne
    {
        return $this->hasOne(Order::class, "email", "email")
            ->where("status", "=", "Verified");
    }

    public function order_details(): HasManyThrough
    {
        return $this->hasManyThrough(
            OrderDetail::class,
            Order::class,
            "email",
            "order_id",
            "email",
            "id"
        );
    }

    protected $fillable = [
        "email",
        "password",
        "fullname",
        "address",
        "phone_number",
    ];
}
