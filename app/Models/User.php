<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $fillable = [
        "email",
        "password",
        "fullname",
        "address",
        "phone_number",
    ];
}
