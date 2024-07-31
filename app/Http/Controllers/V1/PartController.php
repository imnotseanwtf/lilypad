<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Part\StorePartRequest;
use App\Http\Requests\Part\UpdatePartRequest;
use App\Models\Part;
use App\Models\PartType;
use App\Models\Product;
use App\Models\PurchaseOrderItemType;
use App\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PartController extends Controller
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
    public function store(StorePartRequest $storePartRequest): JsonResponse
    {
        try {
            $uom = UnitOfMeasure::where('name', $storePartRequest->uom)->firstOrFail();
            $partType = PartType::where('name', $storePartRequest->partType)->firstOrFail();
            $poItemType = PurchaseOrderItemType::where('name', $storePartRequest->partType)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        };

        $part = Part::create(
            $storePartRequest->only(
                [
                    'partDetails',
                    'upc',
                    'weight',
                    'width',
                    'consumptionRate',
                    'revision',
                ]
            ) +
                [
                    'num' => $storePartRequest->partNumber,
                    'description' => $storePartRequest->partDescription,
                    'uomId' => $uom->id,
                    'typeId' => $partType->id,
                    'activeFlag' => $storePartRequest->active,
                    'weightUomId' => $storePartRequest->weightUom,
                    'len' => $storePartRequest->lenght,
                    'sizeUomId' => $storePartRequest->sizeUom,
                    'url' => $storePartRequest->pictureUrl,
                    'defaultPoItemTypeId' => $poItemType->id,
                ]
        );

        return response()->json(
            [
                'partData' => $part,
                'message' => 'Product Created Successfully!',
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Part $part): JsonResponse
    {
        return response()->json($part, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePartRequest $updatePartRequest, Part $part): JsonResponse
    {
        $part->update($updatePartRequest->validated());

        $product = Product::where('partId', $part->id)->firstOrFail();
        $product->update($updatePartRequest->validated() + ['partId' => $part->id]);

        return response()->json(
            [
                'partData' => $part,
                'productData' => $product,
                'message' => 'Product Updated Successfully!',
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Part $part): JsonResponse
    {
        $part->delete();

        return response()->json(
            [
                'message' => 'Part Deleted Successfully!'
            ],
            Response::HTTP_OK
        );
    }
}
