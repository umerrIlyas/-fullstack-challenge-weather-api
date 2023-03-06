<?php

namespace App\Http\Resources;

use App\Http\Services\WeatherApiService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $weatherApiService = new WeatherApiService();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'weather' => $weatherApiService->getUserWeatherDetails($this->latitude,  $this->longitude),
        ];
    }
}
