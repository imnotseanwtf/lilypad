<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryAndState\StoreCountryAndStateRequest;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CountryAndStateController extends Controller
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
    public function store(StoreCountryAndStateRequest $storeCountryAndStateRequest): JsonResponse
    {
        $country = Country::create(['name' => $storeCountryAndStateRequest->countryName]);

        $state = State::create(['name' => $storeCountryAndStateRequest->stateName]);

        return response()->json(
            [
                'message' => 'Country And State Created Successfully!',
                'country' => $country,
                'state' => $state,
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
