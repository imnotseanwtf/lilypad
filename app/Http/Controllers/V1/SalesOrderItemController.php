<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesOrderItem\StoreSalesOrderItemRequest;
use App\Http\Requests\SalesOrderItem\UpdateSalesOrderItemRequest;
use App\Models\SalesOrderItems;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SalesOrderItemController extends Controller
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
    public function store(StoreSalesOrderItemRequest $storeSalesOrderItemRequest): JsonResponse
    {
        $salesOrderItems = [];

        foreach ($storeSalesOrderItemRequest->validated()['items'] as $item) {
            $item['taxableFlag'] = $storeSalesOrderItemRequest->Flas;
            $salesOrderItems[] = SalesOrderItems::create($item);
        }

        return response()->json(
            [
                'data' => $salesOrderItems,
                'message' => 'Sales Order Item Created Succesfully!'
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesOrderItems $salesOrderItems): JsonResponse
    {
        return response()->json($salesOrderItems, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesOrderItemRequest $updateSalesOrderItemRequest, SalesOrderItems $salesOrderItems): JsonResponse
    {
        $salesOrderItems->update($updateSalesOrderItemRequest->validated());

        return response()->json(
            [
                'data' => $salesOrderItems,
                'message' => 'Sales Order Item Updated Successfully!'
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesOrderItems $salesOrderItems): JsonResponse
    {
        $salesOrderItems->delete();

        return response()->json(
            [
                'message' => 'Sales Order Item Deleted SuccessfulLy!'
            ],
            Response::HTTP_OK
        );
    }
}
