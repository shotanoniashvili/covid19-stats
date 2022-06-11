<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index() {
        $query = Country::with('latestStatistics')->orderBy('code');

        return CountryResource::collection($query->get());
    }
}
