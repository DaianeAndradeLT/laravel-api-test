<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiFakeServices
{

    const URL = 'https://fakestoreapi.com';

    private static function response($body, $status): array
    {
        return ["body" => $body, "status" => $status];
    }

    public static function getProducts(?int $limit = 10): array
    {
        $pageAmount = $limit ? "?limit=$limit" : '';

        $url = self::URL . "/products$pageAmount";
        $result = Http::get($url);
        return self::response($result->json(), $result->status());
    }

    public static function createProduct(array $products): array
    {
        $url = self::URL . '/products';
        $result = Http::post($url, $products);

        return self::response($result->json(), $result->status());
    }

    public static function updateProduct($product): array
    {
        $url = self::URL . '/products/' . $product['id'];
        $result = Http::put($url, $product);
        return self::response($result->json(), $result->status());
    }

    public static function deleteProduct($id): array
    {
        $url = self::URL . '/products/' . $id;
        $result = Http::delete($url);
        return self::response($result->json(), $result->status());
    }
}
