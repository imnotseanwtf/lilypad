<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pick\StorePickRequest;
use App\Http\Requests\Pick\UpdatePickRequest;
use App\Models\Location;
use App\Models\Part;
use App\Models\PartToTracking;
use App\Models\PartTracking;
use App\Models\Pick;
use App\Models\Serial;
use App\Models\SerialNumber;
use App\Models\Tag;
use App\Models\TrackingInfo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PickController extends Controller
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
    public function store(StorePickRequest $storePickRequest): JsonResponse
    {
        foreach ($storePickRequest->validated() as $item) {
            $part = Part::where('num', $item['partNum'])->firstOrFail();

            $partTracking = PartTracking::where('name', $item['partTrackingType'])->firstOrFail();

            try {
                $partToTracking = PartToTracking::where('partId', $part->id)
                    ->where('partTrackingId', $partTracking->id)
                    ->firstOrFail();
            } catch (ModelNotFoundException $e) {
                return response()->json(
                    [
                        'message' => 'Part tracking not found for the given part and tracking ID.',
                    ],
                    Response::HTTP_NOT_FOUND
                );
            }

            if ($item['partTrackingType'] === 'Serial Number') {
                $serialNumbers = $item['trackingInfo'];
                $serialCount = count($serialNumbers);

                $tag = Tag::where('partId', $part->id)
                    ->first();
            
                if (!$tag) {
                    return response()->json(['message' => 'Tag not found for this part'], Response::HTTP_NOT_FOUND);
                }
            
                if ($serialCount !== (int) $tag->qty) {
                    return response()->json(['message' => 'Serial number count does not match inventory quantity'], Response::HTTP_BAD_REQUEST);
                }
            
                foreach ($serialNumbers as $serialNumber) {
                    try {
                        $serial = SerialNumber::where('serialNum', $serialNumber)
                            ->where('partTrackingId', $partToTracking->partTrackingId)
                            ->firstOrFail();
                        
                        if ($part->id !== $tag->partId) {
                            return response()->json(['message' => 'Part Serial does not exist'], Response::HTTP_BAD_REQUEST);
                        }
                    } catch (ModelNotFoundException $e) {
                        return response()->json(['message' => 'Serial Number doesn\'t exist'], Response::HTTP_NOT_FOUND);
                    }
                }
                $trackingInfo = TrackingInfo::create(['partTrackingId' => $partTracking->id]);
            } elseif ($item['partTrackingType'] === 'Expiration Date') {
                $trackingInfo = TrackingInfo::create(['partTrackingId' => $partTracking->id, 'infoDate' => $item['trackingInfo']]);
            } elseif (in_array($item['partTrackingType'], ['Revision Level', 'Lot Number'])) {
                $trackingInfo = TrackingInfo::create(['partTrackingId' => $partToTracking->partTrackingId, 'info' => $item['trackingInfo']]);
            }

            $location = Location::where('name', $item['locationName'])->firstOrFail();

            $pick = Pick::create(
                [
                    'num' => $storePickRequest->pickNum,
                    'locationGroupId' => $location->locationGroupId,
                    'dateCreated' => Carbon::now(),
                    'dateFinished' => Carbon::now(),
                    'dateLastModified' => Carbon::now(),
                    'dateScheduled' => Carbon::now(),
                    'dateStarted' => Carbon::now(),
                ]
            );
        }


        return response()->json(
            [
                'message' => 'Pick Created Successfully!',
                'serialNum' => $serialNumber ?? null,
                'trackingInfo' => $trackingInfo ?? null,
                'pick' => $pick  ?? null,
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Pick $pick): JsonResponse
    {
        return response()->json($pick, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePickRequest $updatePickRequest, Pick $pick): JsonResponse
    {
        $location = Location::where('name', $updatePickRequest->locationName)->firstOrFail();

        $pick->update(
            $updatePickRequest->validated() +
                [
                    'num' => $updatePickRequest->pickNum,
                    'locationGroupId' => $location->locationGroupId,
                ]
        );

        return response()->json(
            [
                'message' => 'Pick Updated Successfully!',
                'pick' => $pick
            ],
            Response::HTTP_OK
        );
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pick $pick): JsonResponse
    {
        $pick->delete();

        return response()->json(
            [
                'message' => 'Pick Deleted Successfully!'
            ],
            Response::HTTP_OK
        );
    }
}
