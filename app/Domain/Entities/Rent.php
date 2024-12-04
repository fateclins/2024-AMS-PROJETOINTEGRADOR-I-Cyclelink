<?php

namespace App\Domain\Entities;

use App\Domain\Entities\Bike;
use App\Domain\Entities\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = [
        'bike_id',
        'user_id',
        'price',
        'color',
        'photo_path',
    ];

    /**
     * Get the user that owns the rent.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bike that is being rented.
     */
    public function bike()
    {
        return $this->belongsTo(Bike::class);
    }
}

?>