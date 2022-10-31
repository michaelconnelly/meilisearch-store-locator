<?php

namespace Database\Factories;

use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    public $location;

    public function __construct()
    {
        parent::__construct();

        $this->getLocation();
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'client_name' => $this->faker->company(),
            'postcode' => $this->location['postcode'],
            'lat' => $this->location['latitude'],
            'lng' => $this->location['longitude'],
        ];
    }

    public function getLocation()
    {
        $url = config('postcodes_io.postcodes_io_url') . '/random/postcodes';

        $location = Http::get($url)->json('result');

        if($this->validateLocation($location)) {
            $this->location = $location;
        }
    }

    public function validateLocation($location)
    {
        if(in_array(null, [$location['latitude'], $location['longitude']])) {
            return $this->getLocation();
        }

        if (Store::firstWhere('postcode', $location['postcode'])) {
            return $this->getLocation();
        }

        return true;
    }

}
