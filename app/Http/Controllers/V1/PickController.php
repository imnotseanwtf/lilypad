<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pick\StorePickRequest;
use App\Http\Requests\Pick\UpdatePickRequest;
use App\Models\InventoryLog;
use App\Models\Part;
use App\Models\Pick;
use App\Models\PickItem;
use App\Models\Product;
use App\Models\TableReference;
use App\Models\TrackingInfo;
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
        $items = $storePickRequest->input('items', []);

        foreach ($items as $item) {
            $part = Part::find($item['partId']);

            $tableReference = TableReference::find($storePickRequest->recordId);

            if ($part->trackingFlag == true) {
                $inventoryLog = InventoryLog::where('partId', $part->id)->firstOrFail();

                $product = Product::where('partId', $part->id)->firstOrFail();

                $trackingInfo = TrackingInfo::create(
                    $storePickRequest->only(
                        [
                            'info',
                            'infoDate',
                            'infoDouble',
                            'infoInteger',
                            'qty',
                            'recordId',
                        ]
                    ) +
                        [
                            'tableId' => $tableReference->tableId,
                            'partTrackingId' => $inventoryLog->partTrackingId,
                        ]
                );
            }
        }

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
                'trackingInfo' => $trackingInfo
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
                    'statusId' => $updatePickRequest->pickStatusId,
                    'typeId' => $updatePickRequest->pickTypeId,
                ]
        );

        foreach ($updatePickRequest->items as $item) {
            $pickItem = PickItem::find($item['id']);

            if ($pickItem) {
                $pickItem->update(
                    array_merge(
                        $item,
                        [
                            'statusId' => $item['pickItemStatusId'],
                            'typeId' => $item['pickItemTypeId'],
                            'pickId' => $pick->id,
                        ]
                    )
                );
            } else {
                PickItem::create(
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
        }

        foreach ($updatePickRequest->items as $item) {
            $part = Part::find($item['partId']);
            $tableReference = TableReference::find($updatePickRequest->recordId);

            if ($part && $part->trackingFlag == true) {
                $inventoryLog = InventoryLog::where('partId', $part->id)->firstOrFail();

                $trackingInfo = TrackingInfo::updateOrCreate(
                    [
                        'partTrackingId' => $inventoryLog->partTrackingId,
                    ],
                    $updatePickRequest->only(
                        [
                            'info',
                            'infoDate',
                            'infoDouble',
                            'infoInteger',
                            'qty',
                            'recordId',
                        ]
                    ) +
                        [
                            'tableId' => $tableReference->tableId,
                        ]
                );
            }
        }

        return response()->json(
            [
                'message' => 'Pick Updated Successfully!',
                'pickData' => $pick,
                'trackingInfo' => isset($trackingInfo) ? $trackingInfo : null
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
