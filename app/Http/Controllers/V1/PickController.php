<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pick\StorePickRequest;
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

        $pickItem = PickItem::create(
            $storePickRequest->only([
                'destTagId',
                'orderId',
                'orderTypeId',
                'partId',
                'poItemId',
                'qty',
                'shipId',
                'slotNum',
                'soItemId',
                'srcLocationId',
                'srcTagId',
                'tagId',
                'uomId',
                'woItemId',
                'xoItemId'
            ]) +
                [
                    'statusId' => $storePickRequest->pickItemStatusId,
                    'typeId' => $storePickRequest->pickItemTypeId,
                ]
        );

        return response()->json(
            [
                'message' => 'Pick Created Successfully!',
                'pickData' => $pick,
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
