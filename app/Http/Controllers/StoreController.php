<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Store;
use Illuminate\Http\Request;
use MeiliSearch\Endpoints\Indexes;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\StoreResource;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('StoreLocator', [
            'stores' => $this->postcodeIsValid($request->postcode) ? $this->getStores($request->postcode, $request->distance) : collect(),
            'filters' => $request->only(['distance', 'postcode'])
        ]);
    }

    protected function postcodeIsValid($postcode)
    {
        return Http::get(config('postcodes_io.postcodes_io_url') . "/postcodes/$postcode/validate")->json('result');
    }

    protected function getStores($postcode, $distance)
    {
        $location =  $this->getLocation($postcode);

        $distance = $distance * 1000;

        $results = Store::search('', function (Indexes $meiliSearch) use ($location, $distance) {
            $geoRadiusData = implode(',', [$location['latitude'], $location['longitude'], $distance]);

            $geoPointData = implode(',', [$location['latitude'], $location['longitude']]);

            return $meiliSearch->search('', [
                'filter' => "_geoRadius($geoRadiusData)",
                'sort' => ["_geoPoint($geoPointData):asc"],
            ]);
        })->raw();

        return StoreResource::collection($results['hits']);
    }

    protected function getLocation($postcode)
    {
        return Http::get(config('postcodes_io.postcodes_io_url') . "/postcodes/$postcode")->json('result');
    }
}
