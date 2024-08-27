<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pick\StorePickRequest;
use App\Http\Requests\Pick\UpdatePickRequest;
use App\Models\Pick;
use App\Models\PickItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $pick = Pick::create(
            $storePickRequest->only([
                'dateCreated',
                'dateFinished',
                'dateLastModified',
                'dateScheduled',
                'dateStarted',
                'locationGroupId',
                'num',
                'priority',
                'userId',
            ]) +
                [
                    'statusId' =>  $storePickRequest->pickStatusId,
                    'typeId' => $storePickRequest->pickTypeId,
                ]
        );

        foreach ($storePickRequest->items as $item) {
            $pickItem = PickItem::create(
                array_merge(
                    $item,
                    [
                        'statusId' => $item['pickItemStatusId'],
                        'typeId' => $item['pickItemTypeId'],
                        'pickId' => $pick->id,
                    ]
                )
            );
        }


        return response()->json(
            [
                'message' => 'Pick Created Successfully!',
                'pickData' => $pick,
                'pickItemData' => $pickItem,
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
        $pick->update(
            $updatePickRequest->only([
                'dateCreated',
                'dateFinished',
                'dateLastModified',
                'dateScheduled',
                'dateStarted',
                'locationGroupId',
                'num',
                'priority',
                'userId',
            ]) +
                [
                    'statusId' =>  $updatePickRequest->pickStatusId,
                    'typeId' => $updatePickRequest->pickTypeId,
                ]
        );

        foreach ($updatePickRequest->items as $item) {
            $pickItem = PickItem::updateOrCreate(
                [
                    'pickId' => $pick->id,
                ],
                array_merge(
                    $item,
                    [
                        'statusId' => $item['pickItemStatusId'],
                        'typeId' => $item['pickItemTypeId'],
                    ]
                )
            );
        }

        return response()->json(
            [
                'message' => 'Pick Updated Successfully!',
                'pickData' => $pick,
                'pickItemData' => $pickItem,
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
