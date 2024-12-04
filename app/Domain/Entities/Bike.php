<?php

namespace App\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bikes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'year',
        'type_bike_id',
        'brand_id',
    ];

    /**
     * Get the brand associated with the bike.
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the type of bike associated with the bike.
     */
    public function typeBike()
    {
        return $this->belongsTo(TypeBike::class, 'type_bike_id');
    }
}
