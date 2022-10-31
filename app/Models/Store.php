<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Store extends Model
{
    use HasFactory;
    use Searchable;

    public function toSearchableArray()
    {
        return $array = [
            'client_name' => $this->client_name,
            'postcode' => $this->postcode,
            '_geo' => [
                'lat' => $this->lat,
                'lng' => $this->lng,
            ],
        ];
    }
}
