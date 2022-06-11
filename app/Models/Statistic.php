<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;

    protected $fillable = ['confirmed', 'recovered', 'death'];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
