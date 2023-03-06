<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Cache;

class WeatherApiService
{
    protected $client;

    protected $cacheExpired = 3600; // 1 hour

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('weather-api.URL'),
            'verify' => false,
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
    }

    public function getUserWeatherDetails(float $lang, float $long, string $temperatureUnit = 'fahrenheit')
    {
        $key = "$lang-$long";
        $cached = $this->checkCache($key);

        if ($cached) {
            return $cached;
        } else {
            $endPoint = "/v1/forecast?latitude=$lang&longitude=$long&temperature_unit=$temperatureUnit&current_weather=true";
            $response = $this->sendRequest('GET', $endPoint);

            $this->storeCache($key, $response);

            return $response;
        }
    }

    public function checkCache(string $key)
    {
        if (cache()->has($key)) {
            return Cache::get($key);
        }
        return false;
    }

    public function storeCache(string $key, array $value)
    {
        Cache::put($key, $value, $this->cacheExpired);
    }

    protected function sendRequest(string $method, string $endpoint, array $params = [])
    {
        try {
            // Async Request with await 
            $response = $this->client->request($method, $endpoint, $params);
            $response = json_decode($response->getBody(), true);
        } catch (GuzzleException $e) {
            $response = $e->getResponse();
        }

        return $response;
    }
}
