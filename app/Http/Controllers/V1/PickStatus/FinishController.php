<?php

namespace App\Http\Controllers\V1\PickStatus;

use App\Http\Controllers\Controller;
use App\Models\PickItem;
use App\Models\Ship;
use App\Models\ShipCarton;
use App\Models\ShipItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinishController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $finishItemRequest = Validator::make(
            $request->all(),
            [
                '*.pickItemId' => ['required', 'numeric', 'exists:pickitem,id']
            ]
        );

        foreach ($finishItemRequest->validated() as $item) {
            $pickItem = PickItem::findOrFail($item['pickItemId']);

            $pickItem->update(
                [
                    'statusId' => 40
                ]
            );

            $ship = Ship::create(
                [
                    'statusId' => 10,
                    'carrierId' => $pickItem->salesOrderItem->salesOrder->carrierId,
                    'carrierServiceId' => $pickItem->salesOrderItem->salesOrder->carrierServiceId,
                    'locationGroupId' => $pickItem->salesOrderItem->salesOrder->locationGroupId,
                    'soId' => $pickItem->salesOrderItem->salesOrder->id,
                ]
            );

            $shipCarton = ShipCarton::create(
                [
                    'additionalHandling' => true,
                    'carrierId' => $pickItem->salesOrderItem->salesOrder->carrierId,
                    'cartonNum' => 1,
                    'shipId' => $ship->id,
                    'shipperRelease' => true,
                ]
            );

            $shipItem = ShipItem::create(
                [
                    'shipCartonId' => $shipCarton->id,
                    'shipId' => $ship->id,
                    'uomId' => $pickItem->uomId
                ]
            );
        }

        return response()->json(
            [
                'message' => 'Pick Item is Finish',
                'ship' => $ship,
                'shipItem' =>$shipItem,
            ]
        );
    }
}
