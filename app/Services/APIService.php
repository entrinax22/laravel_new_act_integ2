<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class APIService
{
    public function client(): PendingRequest
    {
       return Http::acceptJson()
            ->connectTimeout(5)
            ->timeout(10)
            ->retry(2, 300, throw: false);
    }

    public function products(int $limit = 5)
    {
        $response = $this->client()->get(config('services.dummyjson.base_url').'/products', ['limit' => $limit]);

        if ($response->failed()) {
            return [
                'products' => [],
                'error' => 'Failed to fetch data from DummyJSON API'
            ];
        }

        $products = collect($response->json('products'))->map(function ($product) {
            return [
                'id' => $product['id'] ?? null,
                'name' => $product['title'] ?? 'Unknown',
                'price' => $product['price'] ?? 0,
                'category' => $product['category'] ?? 'Unknown',
                'image' => $product['thumbnail'] ?? null,
            ];
        });

        return [
            'products' => $products,
            'error' => null
        ];
    }

}