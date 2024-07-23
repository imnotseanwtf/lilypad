<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalesOrder\StoreSalesOrderRequest;
use App\Http\Requests\SalesOrder\UpdateSalesOrderRequest;
use App\Http\Requests\SalesOrderItem\StoreSalesOrderItemRequest;
use App\Models\SalesOrder;
use App\Models\SalesOrderItems;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SalesOrderController extends Controller
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
    public function store(StoreSalesOrderRequest $storeSalesOrderRequest): JsonResponse
    {
        $salesOrder = SalesOrder::create($storeSalesOrderRequest->except('items'));

        $salesOrderItems = [];

        foreach ($storeSalesOrderRequest->validated()['items'] as $item) {
            $item['soId'] = $salesOrder->id;
            $item['statusId'] = $storeSalesOrderRequest->statusId;
            $salesOrderItems[] = SalesOrderItems::create($item);
        }

        return response()->json(
            [
                'salesOrder' => $salesOrder,
                'salesOrderItem' => $salesOrderItems,
                'message' => 'Sales Order Created Successfully!',
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesOrder $salesOrder): JsonResponse
    {
        return response()->json($salesOrder, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesOrderRequest $updateSalesOrderRequest, SalesOrder $salesOrder): JsonResponse
    {
        $existingItems = SalesOrderItems::where('soId', $salesOrder->id)->get();
    
        $salesOrder->update($updateSalesOrderRequest->except('items'));
    
        $updatedItems = [];
        $newItems = $updateSalesOrderRequest->validated()['items'];
    
        foreach ($newItems as $item) {
            if (isset($item['id'])) {
                $existingItem = $existingItems->where('id', $item['id'])->first();
                if ($existingItem) {
                    $existingItem->update($item);
                    $updatedItems[] = $existingItem;
                }
            } else {
                $item['soId'] = $salesOrder->id;
                $item['statusId'] = $updateSalesOrderRequest->statusId;
                $newItem = SalesOrderItems::create($item);
                $updatedItems[] = $newItem;
            }
        }
    
        $itemsToDelete = $existingItems->whereNotIn('id', array_column($newItems, 'id'));
        foreach ($itemsToDelete as $itemToDelete) {
            $itemToDelete->delete();
        }
    
        return response()->json(
            [
                'salesOrder' => $salesOrder,
                'salesOrderItems' => $updatedItems,
                'message' => 'Sales Order Updated Successfully!',
            ],
            Response::HTTP_OK
        );
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesOrder $salesOrder): JsonResponse
    {
        $salesOrder->delete();

        return response()->json(
            [
                'message' => 'Sales Order Deleted Successfully!'
            ],
            Response::HTTP_OK
        );
    }
}
