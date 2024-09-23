<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventoryRequest;
use App\Models\Location;
use App\Models\Part;
use App\Models\PartCost;
use App\Models\PartToTracking;
use App\Models\Serial;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InventoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreInventoryRequest $storeInventoryRequest): JsonResponse
    {
        $part = Part::where('num', $storeInventoryRequest->partNumber)->firstOrFail();

        $partToTracking = PartToTracking::where('partId', $part->id)->firstOrFail();

        if ($partToTracking->partTracking->name === 'Serial Number') {
            $serialFlag = true;
        }

        $location = Location::where('name', $storeInventoryRequest->location)->firstOrFail();

        $partToTracking = PartToTracking::where('partId', $part->id)->firstOrFail();

        $tag = Tag::firstOrCreate(
            [
                'qty' => $storeInventoryRequest->qty,
                'qtyCommitted' => $storeInventoryRequest->qty,
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
                'avgCost' => $storeInventoryRequest->cost,
                'dateCreated' => now(),
                'qty' => $storeInventoryRequest->qty,
                'totalCost' => $storeInventoryRequest->cost,
                'partId' => $part->id,
            ]
        );

        return response()->json(
            [
                'message' => 'Inventory Created Successfully!',
                'tag' => $tag ?? null,
                'serial' => $serial ?? null,
                'partCost' => $partCost ?? null,
            ],
            Response::HTTP_CREATED,
        );
    }
}
