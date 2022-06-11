<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Covid19StatService
{
    private $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('COVID19_API_BASE_URL');
    }

    public function getCountries() {
        $url = $this->baseUrl.'/countries';
        $response = Http::get($url);

        if ($response->status() != 200) {
            $this->log($response, $url);
            throw new \Exception('Error while fetching countries from api');
        }

        return $response->object();
    }

    public function getStatistics($code) {
        $url = $this->baseUrl.'/get-country-statistics';
        $response = Http::post($url, [
            'code' => $code
        ]);

        if ($response->status() != 200) {
            $this->log($response, $url);
            throw new \Exception('Error while fetching statistics for "'.$code.'" from api');
        }

        return $response->object();
    }

    private function log(Response $response, $url) {
        $error = [
            'date' => (new \DateTime())->format('Y-m-d H:i:s'),
            'url' => $url,
            'status' => $response->status(),
            'content' => $response->body()
        ];
        Log::warning(json_encode($error));
    }
}
