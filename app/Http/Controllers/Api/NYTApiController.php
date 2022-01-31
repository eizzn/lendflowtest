<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BestSellersRequest;
use App\Services\Contracts\NYTApiService;

class NYTApiController extends Controller
{
    public function bestSellers(BestSellersRequest $request, NYTApiService $service)
    {
        $validatedData = $request->validated();

        return $service->getBestSellers($validatedData);
    }
}
