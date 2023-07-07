<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpf',
        'user_id',
        'birthdate',
        'phone'
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(ClientAddress::class);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class)->withDefault(function (Cart $cart, Client $client) {
            $client
              ->cart()
              ->create(['amount' => 0, 'discount' => 0, 'shipping' => 0])->get();
        });
}
}
