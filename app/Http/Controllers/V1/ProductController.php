<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $storeProductRequest): JsonResponse
    {
        $product = Product::create($storeProductRequest->validated());

        return response()->json(
            [
                'product' => $product,
                'message' => 'Product Create Successfully!'
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json($product, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $updateProductRequest, Product $product): JsonResponse
    {
        $product->update($updateProductRequest->validated());

        return response()->json(
            [
                'product' => $product,
                'message' => 'Product Updated Successfully!'
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json(
            [
                'message' => 'Product Deleted Successfully!'
            ],
            Response::HTTP_OK
        );
    }
}
