<?php

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

interface NYTApiService
{
    /**
     * @param array $params
     * @return Collection
     */
    public function getBestSellers(array $params): Collection;
}
