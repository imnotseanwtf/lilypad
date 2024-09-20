<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryLog\StoreInventoryLogRequest;
use App\Http\Requests\InventoryLog\UpdateInventoryLogRequest;
use App\Models\InventoryLog;
use App\Models\Location;
use App\Models\Part;
use App\Models\PartCost;
use App\Models\PartToTracking;
use App\Models\Serial;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InventoryLogController extends Controller
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
    public function store(StoreInventoryLogRequest $storeInventoryLogRequest): JsonResponse
    {
        $part = Part::where('num', $storeInventoryLogRequest->partNumber)->firstOrFail();

        $partToTracking = PartToTracking::where('partId', $part->id)->firstOrFail();

        if ($partToTracking->partTracking->name === 'Serial Number') {
            $serialFlag = true;
        }

        $location = Location::where('name', $storeInventoryLogRequest->location)->firstOrFail();

        $partToTracking = PartToTracking::where('partId', $part->id)->firstOrFail();

        $inventory = InventoryLog::create(
            $storeInventoryLogRequest->only(
                [
                    'cost'
                ]
            ) + [
                'partId' => $part->id,
                'begLocationId' => $location->id,
                'endLocationId' => $location->id,
                'changeQty' => $storeInventoryLogRequest->qty,
                'qtyOnHand' => $storeInventoryLogRequest->qty,
                'dateCreated' => $storeInventoryLogRequest->date,
                'partTrackingId' => $partToTracking->partTrackingId,
                'locationGroupId' => $location->locationGroupId,
            ],
        );

        $tag = Tag::firstOrCreate(
            [
                'qty' => $storeInventoryLogRequest->qty,
                'qtyCommitted' => $storeInventoryLogRequest->qty,
                'serializedFlag' => $serialFlag ?? false,
                'locationId' => $location->id,
            ]
        );

        $serial = Serial::firstOrCreate(
            [
                'tagId' => $tag->id,
            ]
        );

        $partCost = PartCost::create(
            [
                'avgCost' => $storeInventoryLogRequest->cost,
                'dateCreated' => Carbon::now(),
                'qty' => $storeInventoryLogRequest->qty,
                'totalCost' => $storeInventoryLogRequest->cost,
                'partId' => $part->id,
            ]
            );

        return response()->json(
            [
                'message' => 'Inventory Created Successfully!',
                'inventory' => $inventory,
                'tag' => $tag ?? null,
                'serial' => $serial ?? null,
                'partCost' => $partCost ?? null,
            ],
            Response::HTTP_CREATED,
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryLog $inventoryLog): JsonResponse
    {
        return response()->json($inventoryLog, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryLogRequest $updateInventoryLogRequest, InventoryLog $inventoryLog): JsonResponse
    {
        $part = Part::where('num', $updateInventoryLogRequest->partNumber)->firstOrFail();

        $location = Location::where('name', $updateInventoryLogRequest->location)->firstOrFail();

        $partToTracking = PartToTracking::where('partId', $part->id)->firstOrFail();

        $updateData = $updateInventoryLogRequest->only(['cost']) + [
            'partId' => $part->id,
            'begLocationId' => $location->id,
            'endLocationId' => $location->id,
            'changeQty' => $updateInventoryLogRequest->qty,
            'qtyOnHand' => $updateInventoryLogRequest->qty,
            'dateCreated' => $updateInventoryLogRequest->date,
            'partTrackingId' => $partToTracking->partTrackingId,
            'locationGroupId' => $location->locationGroupId,
        ];

        $inventoryLog->update($updateData);

        $inventoryLog->refresh();

        return response()->json(
            [
                'message' => 'Inventory Updated Successfully!',
                'inventory' => $inventoryLog,
            ],
            Response::HTTP_OK,
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryLog $inventoryLog): JsonResponse
    {
        $inventoryLog->delete();

        return response()->json(
            [
                'message' => 'Inventory Deleted Successfully!',
            ],
            Response::HTTP_OK,
        );
    }
}
