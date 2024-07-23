<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountType\StoreAccountTypeRequest;
use App\Http\Requests\AccountType\UpdateAccountTypeRequest;
use App\Models\AccountType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountTypeController extends Controller
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
    public function store(StoreAccountTypeRequest $storeAccountTypeRequest): JsonResponse
    {
        $accountType = AccountType::firstOrCreate(['name' => $storeAccountTypeRequest->validated()]);

        return response()->json(
            [
                'account-type' => $accountType->name,
                'message' => 'Account Created Successfully!'
            ],
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(AccountType $accountType): JsonResponse
    {
        return response()->json($accountType, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountTypeRequest $updateAccountTypeRequest, AccountType $accountType): JsonResponse
    {
        $accountType->update($updateAccountTypeRequest->validated());

        return response()->json(
            [
                'data' => $accountType,
                'message' => 'Account Type Updated Successfully!'
            ],
            Response::HTTP_OK
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AccountType $accountType): JsonResponse
    {
        $accountType->delete();

        return response()->json(
            [
                'message' => 'Account Type Deleted Successfully!'
            ],
            Response::HTTP_OK
        );
    }
}
