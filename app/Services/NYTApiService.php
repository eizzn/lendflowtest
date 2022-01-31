<?php

namespace App\Services;

use App\Exceptions\MissingRequiredApiKeyException;
use App\Services\Contracts\NYTApiService as BaseService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class NYTApiService implements BaseService
{
    protected $apiKey;
    protected $apiBaseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.nyt.key');
        if (is_null($this->apiKey) || $this->apiKey === '') {
            throw new MissingRequiredApiKeyException('Required API not provided', 500);
        }
        $this->apiBaseUrl = config('services.nyt.url');
    }

    public function getBestSellers(array $params): Collection
    {
        $params['api-key'] = $this->apiKey;
        $url = $this->apiBaseUrl . '/lists/best-sellers/history.json?';
        // the NYT API seems to only accept one isbn at a time
        // if isbn provided, loop over each and combine results
        if (array_key_exists('isbn', $params)) {
            $results = [];
            $tmpParams = $params;
            foreach ($params['isbn'] as $isbn) {
                $tmpParams['isbn'] = $isbn;
                $formattedParams = http_build_query($tmpParams);
                $response = Http::get($url . $formattedParams);
                $body = json_decode($response->body());
                foreach ($body->results as $result) {
                    $results[] = $result;
                }
            }
        } else {
            $formattedParams = http_build_query($params);
            $response = Http::get($url . $formattedParams);

            $body = json_decode($response->body());
            $results = $body->results;
        }

        return collect($results);
    }
}
