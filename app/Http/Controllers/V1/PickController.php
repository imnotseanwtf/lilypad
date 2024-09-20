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
use App\Models\SerialNumber;
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
                try {
                 $serialNumber = SerialNumber::where('serialNum', $item['trackingInfo'])->where('partTrackingId', $partToTracking->partTrackingId)->firstOrFail();
                } catch (ModelNotFoundException $e) {
                    return response()->json(
                        [
                            'message' => 'Serial Number doesnt Exists',
                        ],
                        Response::HTTP_NOT_FOUND
                    );
                }

                $trackingInfo = TrackingInfo::create(
                    [
                        'partTrackingId' => $partTracking->id
                    ]
                );
            }

            if ($item['partTrackingType'] === 'Expiration Date') {
                $trackingInfo = TrackingInfo::create(
                    [
                        'partTrackingId' => $partTracking->id,
                        'infoDate' => $item['trackingInfo'],
                    ]
                );
            }

            if ($item['partTrackingType'] === 'Revision Level' || $storePickRequest->partTrackingType === 'Lot Number') {
                $trackingInfo = TrackingInfo::create(
                    [
                        'partTrackingId' => $partToTracking->partTrackingId,
                        'info' => $item['trackingInfo'],
                    ]
                );
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
                'pick' => $pick
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
