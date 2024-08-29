<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryLog\StoreInventoryLogRequest;
use App\Models\InventoryLog;
use App\Models\Location;
use App\Models\Part;
use App\Models\PartToTracking;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInventoryLogRequest $storeInventoryLogRequest): JsonResponse
    {
        $part = Part::where('num', $storeInventoryLogRequest->partNumber)->firstOrFail();
        $location = Location::where('name', $storeInventoryLogRequest->location)->firstOrFail();

        $partToTracking = PartToTracking::where('partId', $part->id)->firstOrFail();

        $inventory = InventoryLog::create($storeInventoryLogRequest->only(
            [
                'cost'
            ]
        ) +
            [
                'partId' => $part->id,
                'begLocationId' => $location->id,
                'endLocationId' => $location->id,
                'changeQty' => $storeInventoryLogRequest->qty,
                'qtyOnHand' => $storeInventoryLogRequest->qty,
                'dateCreated' => $storeInventoryLogRequest->date,
                'partTrackingId' => $partToTracking->partTrackingId,
                'locationGroupId' => $location->locationGroupId,
            ]
        );

        return response()->json(
            [
                'message' => 'Inventory Created Successfully!',
                'invetory' => $inventory,
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
