<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Part;
use App\Models\Product;
use App\Models\SalesOrderItemType;
use App\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        try {
            $part = Part::where('num', $storeProductRequest->partNumber)->firstOrFail();
            $soItem = SalesOrderItemType::where('name', $storeProductRequest->productSoItemType)->firstOrFail();
            $uom = UnitOfMeasure::where('name', $storeProductRequest->uom)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        $product = Product::create(
            $storeProductRequest->only(
                [
                    'price',
                    'weight',
                    'width',
                    'height',
                    'lenght',
                    'alertNote',
                    'cf'
                ]
            ) +
                [
                    'partId' => $part->id,
                    'num' => $storeProductRequest->productNumber,
                    'description' => $storeProductRequest->productDescription,
                    'details' => $storeProductRequest->productDetails,
                    'activeFlag' => $storeProductRequest->active,
                    'taxableFlag' => $storeProductRequest->taxable,
                    'showSoComboFlag' => $storeProductRequest->combo,
                    'sellableInOtherUoms' => $storeProductRequest->allowUom,
                    'url' => $storeProductRequest->productUrl,
                    'upc' => $storeProductRequest->productUpc,
                    'sku' => $storeProductRequest->productSku,
                    'defaultSoItemType' => $soItem->id,
                    'uomId' => $uom->id,

                    // 'displayTypeId' => 1,
                    // 'incomeAccountId' => 1,
                ]
        );

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
        try {
            // Find related models based on request data
            $part = Part::where('num', $updateProductRequest->partNumber)->firstOrFail();
            $soItem = SalesOrderItemType::where('name', $updateProductRequest->productSoItemType)->firstOrFail();
            $uom = UnitOfMeasure::where('name', $updateProductRequest->uom)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }

        // Update the product with new data
        $product->update(
            $updateProductRequest->only(
                [
                    'price',
                    'weight',
                    'width',
                    'height',
                    'lenght',
                    'alertNote',
                    'cf'
                ]
            ) +
                [
                    'partId' => $part->id,
                    'num' => $updateProductRequest->productNumber,
                    'description' => $updateProductRequest->productDescription,
                    'details' => $updateProductRequest->productDetails,
                    'activeFlag' => $updateProductRequest->active,
                    'taxableFlag' => $updateProductRequest->taxable,
                    'showSoComboFlag' => $updateProductRequest->combo,
                    'sellableInOtherUoms' => $updateProductRequest->allowUom,
                    'url' => $updateProductRequest->productUrl,
                    'upc' => $updateProductRequest->productUpc,
                    'sku' => $updateProductRequest->productSku,
                    'defaultSoItemType' => $soItem->id,
                    'uomId' => $uom->id,
                ]
        );

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
