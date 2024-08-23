<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UOM\StoreUnitOfMeasureRequest;
use App\Http\Requests\UOM\UpdateUnitOfMeasureRequest;
use App\Models\UnitOfMeasure;
use App\Models\UnitOfMeasureType;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UnitOfMeasureController extends Controller
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
    public function store(StoreUnitOfMeasureRequest $storeUnitOfMeasureRequest): JsonResponse
    {
        $uomType = UnitOfMeasureType::where('id', $storeUnitOfMeasureRequest->uomTypeId)->firstOrCreate();

        $uom = UnitOfMeasure::create(
            $storeUnitOfMeasureRequest->only(
                [
                    'name',
                    'readOnly',
                ]
            ) + [
                'activeFlag' => $storeUnitOfMeasureRequest->active,
                'description' => $storeUnitOfMeasureRequest->details,
                'code' => $storeUnitOfMeasureRequest->abbrev,
                'uomType' => $uomType->id,
            ]
        );

        return response()->json(
            [
                'message' => 'Unit Of Measure Created Successfully!',
                'data' => $uom,
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(UnitOfMeasure $unitOfMeasure): JsonResponse
    {
        return response()->json($unitOfMeasure, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitOfMeasureRequest $updateUnitOfMeasureRequest, UnitOfMeasure $uom): JsonResponse
    {
        $uomType = UnitOfMeasureType::where('id', $updateUnitOfMeasureRequest->uomTypeId)->firstOrFail();

        $uom->update(
            $updateUnitOfMeasureRequest->only(
                [
                    'name',
                    'readOnly',
                ]
            ) + [
                'activeFlag' => $updateUnitOfMeasureRequest->active,
                'description' => $updateUnitOfMeasureRequest->details,
                'code' => $updateUnitOfMeasureRequest->abbrev,
                'uomType' => $uomType->id,
            ]
        );

        return response()->json(
            [
                'message' => 'Unit Of Measure Updated Successfully!',
                'data' => $uom,
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnitOfMeasure $unitOfMeasure): JsonResponse
    {
        $unitOfMeasure->delete();

        return response()->json(
            [
                'message' => 'Unit Of Measure Deleted Successfully!',
            ],
            Response::HTTP_OK
        );
    }
}
