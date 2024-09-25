<?php

namespace App\Http\Controllers\V1\ShipStatus;

use App\Http\Controllers\Controller;
use App\Models\Ship;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShipController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Ship $ship): JsonResponse
    {
        $ship->update(
            [
                'statusId' => 30
            ]
        );

        return response()->json(
            [
                'message' => 'Shipped'
            ]
        );
    }
}
