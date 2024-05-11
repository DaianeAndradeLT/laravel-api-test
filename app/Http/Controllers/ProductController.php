<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductsRequest;
use App\Models\Product;
use App\Services\ApiFakeServices;
use App\Services\CsvService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(): JsonResponse
    {
        $products = Product::all();
        return self::responseJson($products->toArray());
    }

    public function create(ProductsRequest $request)
    {
        $product = $request->validated();
        $product = Product::create($product);
        return self::responseJson($product->toArray(), 201, 'Produto criado com sucesso');
    }

    public function update(ProductsRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $product = Product::find($id);
        if(!$product){
            return self::responseJson([], 404, 'Produto não encontrado');
        }

        $product->update($data);
        return self::responseJson($product->toArray());
    }

    public function destroy(int $id): JsonResponse
    {
        Product::destroy($id);
        return self::responseJson(['Ok']);
    }

    public function import(Request $request):JsonResponse
    {
        $file = $request->file('file');
        $response = CsvService::import($file);

        if($response['success']){
            return self::responseJson($response['errors'], 200, 'Produtos importados com sucesso');
        }

        return self::responseJson($response['errors'], 400, 'Erro ao importar produtos');

    }

    public function export()
    {
        $products = Product::all();
        $file = CsvService::export($products);
        return response()->download($file, 'products.csv');
    }

    public function migrateProducts()
    {
        $response = ApiFakeServices::getProducts();
        $products = $response['body'];
        foreach ($products as $product) {
            $product['description'] = substr($product['description'], 0, 250) . '...';
            Product::create($product);
        }

        return self::responseJson([], 200, 'Produtos migrados com sucesso');
    }

    private static function responseJson(?array $data = [], int $status = 200, ?string $message = null): JsonResponse
    {
        if(!$message){
            $message = $status === 200 ? 'Ok' : 'Erro';
        }

        $body = ['message' => $message, 'data' => $data];
        return response()->json($body, $status);
    }
}
