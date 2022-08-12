<?php

namespace App\Http\Controllers;

use App\Http\Requests\JsonRequest;
use App\Http\Services\ProductUpdateService;

class ProductController extends Controller
{
    public function storeUpdateProduct(JsonRequest $request)
    {
        $product_data = json_decode($request->data, true);
        $updatedProduct = new ProductUpdateService();
        $row = $updatedProduct->updateProduct($product_data);
        return response()->json([
            'status' => true,
            'product_info' => $row
        ]);
    }
}
