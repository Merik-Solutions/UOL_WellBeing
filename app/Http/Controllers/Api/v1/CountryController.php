<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Country\CountryResource;
use App\Repositories\interfaces\CountryRepository;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __invoke(CountryRepository $repo)
    {
        $countries = new CountryResource($repo->all());
        return responseJson(
            CountryResource::collection($countries),
            __('Loaded Successfully'),
        );
    }
}
