<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Location\StoreLocationRequest;
use App\Http\Requests\Location\UpdateLocationRequest;
use App\Models\Customer;
use App\Models\Location;
use App\Models\LocationGroup;
use App\Models\LocationType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocationController extends Controller
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
    public function store(StoreLocationRequest $storeLocationRequest): JsonResponse
    {
        $locationType = LocationType::where('name', $storeLocationRequest->type)->firstOrFail();
        $locationGroup = LocationGroup::firstOrCreate(['name' => $storeLocationRequest->locationGroup]);
        $customer = Customer::where('name', $storeLocationRequest->customerName)->firstOrFail();

        $location = Location::create(
            $storeLocationRequest->only(
                [
                    'description',
                    'pickable',
                    'receivable',
                    'sortOrder'
                ]
            ) +
                [
                    'name' => $storeLocationRequest->location,
                    'typeId' => $locationType->id,
                    'locationGroupId' => $locationGroup->id,
                    'defaultCustomerId' => $customer->id,
                    'activeFlag' => $storeLocationRequest->active,
                    'countedAsAvailable' => $storeLocationRequest->available,
                ]
        );

        return response()->json(
            [
                'message' => 'Location Created Successfully!',
                'location' => $location,
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location): JsonResponse
    {
        return response()->json($location, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLocationRequest $updateLocationRequest, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location): JsonResponse
    {
        $location->delete();

        return response()->json(
            [
                'message' => 'Location Created Successfully!',
            ],
            Response::HTTP_OK
        );
    }
}
