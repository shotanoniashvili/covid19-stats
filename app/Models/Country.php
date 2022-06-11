<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function statistics()
    {
        return $this->hasMany(Statistic::class, 'country_id');
    }

    public function latestStatistics()
    {
        return $this->hasOne(Statistic::class, 'country_id')->latest();
    }

    public function getNameAttribute() {
        return json_decode($this->attributes['name'], true)[app()->getLocale()];
    }

    public function saveStatistics($data) {
        $latestStat = $this->latestStatistics;

        if (!$latestStat ||
            strtotime($latestStat->created_at->format('Y-m-d')) < strtotime(date('Y-m-d'))) {

            $this->statistics()->save(new Statistic($data));
        } else {
            $latestStat->updated_at = new \DateTime();
            $latestStat->update($data);
        }
    }
}
