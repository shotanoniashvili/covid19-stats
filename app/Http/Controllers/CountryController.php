<?php

namespace App\Http\Controllers;

use App\Http\Resources\CountryResource;
use App\Models\Country;
use App\Models\Statistic;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends Controller
{
    public function index() {
        $query = Country::with('latestStatistics')->orderBy('code');

        return CountryResource::collection($query->get());
    }

    public function summary() {
        $result = Statistic::select(DB::raw('MAX(created_at) as created_at'), 'confirmed', 'recovered', 'death')
            ->groupBy(['confirmed', 'recovered', 'death'])
            ->get();

        return response()->json([
            'data' => [
                'confirmed' => $result->sum('confirmed'),
                'recovered' => $result->sum('recovered'),
                'death' => $result->sum('death'),
            ]
        ]);
    }
}
