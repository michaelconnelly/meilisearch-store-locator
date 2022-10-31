<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'client' => $this['client_name'],
            'postcode' => $this['postcode'],
            'location' => $this['_geo'],
            'distance' => number_format($this['_geoDistance'] / 1000, 1),
        ];
    }
}
