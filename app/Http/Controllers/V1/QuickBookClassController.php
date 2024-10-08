<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuickBook\StoreQuickBookClassRequest;
use App\Http\Requests\QuickBook\UpdateQuickBookClassRequest;
use App\Models\qbClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuickBookClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuickBookClassRequest $storeQuickBookClassRequest): JsonResponse
    {
        $quickBook = qbClass::create($storeQuickBookClassRequest->only('name') + ['activeFlag' => $storeQuickBookClassRequest->active]);

        return response()->json(
            [
                'message' => 'Quick Book Class Created Successfully!',
                'data' => $quickBook
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(qbClass $qbClass): JsonResponse
    {
        return response()->json($qbClass, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuickBookClassRequest $updateQuickBookClassRequest, qbClass $qbClass): JsonResponse
    {
        $qbClass->update($updateQuickBookClassRequest->only('name') + ['active' => $updateQuickBookClassRequest->active]);

        return response()->json(
            [
                'message' => 'Quick Book Class Updated Successfully!',
                'data' => $qbClass,
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(qbClass $qbClass): JsonResponse
    {
        $qbClass->delete();

        return response()->json(
            [
                'message' => 'Quick Book Class Deleted Successfully!'
            ],
            Response::HTTP_OK
        );
    }
}
